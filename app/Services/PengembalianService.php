<?php

namespace App\Services;

use App\Models\Alat;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\User;
use App\Support\ActivityLogger;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PengembalianService
{
    private const DENDA_PER_HARI = 5000;

    public function create(array $validated, Peminjaman $peminjaman, User $aktor): Pengembalian
    {
        $peminjaman->loadMissing('details.alat', 'user', 'pengembalian');

        if ($peminjaman->status !== 'disetujui') {
            throw ValidationException::withMessages([
                'status' => 'Hanya peminjaman yang sudah disetujui yang bisa dikembalikan.',
            ]);
        }

        if ($peminjaman->pengembalian()->exists()) {
            throw ValidationException::withMessages([
                'pengembalian' => 'Pengembalian untuk transaksi ini sudah dibuat.',
            ]);
        }

        $items = collect($validated['items'] ?? [])
            ->map(fn (array $item) => [
                'alat_id' => (int) $item['alat_id'],
                'qty_kembali' => (int) ($item['qty_kembali'] ?? 0),
                'kondisi_masuk' => $item['kondisi_masuk'],
                'catatan' => $item['catatan'] ?? null,
            ])
            ->filter(fn (array $item) => $item['qty_kembali'] > 0)
            ->values();

        if ($items->isEmpty()) {
            throw ValidationException::withMessages([
                'items' => 'Isi minimal satu item pengembalian.',
            ]);
        }

        return DB::transaction(function () use ($validated, $peminjaman, $aktor, $items) {
            [$hariTerlambat, $denda] = $this->calculateFine($peminjaman, $validated['tanggal_kembali']);
            $diterimaLangsung = $aktor->hasAnyRole([User::ROLE_ADMIN, User::ROLE_PETUGAS]);

            $pengembalian = Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'diterima_oleh' => $diterimaLangsung ? $aktor->id : null,
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'status' => $diterimaLangsung ? 'diterima' : 'diajukan',
                'hari_terlambat' => $hariTerlambat,
                'denda' => $denda,
                'catatan' => $validated['catatan'] ?? null,
            ]);

            foreach ($items as $item) {
                $detailPeminjaman = $peminjaman->details->firstWhere('alat_id', $item['alat_id']);

                if (! $detailPeminjaman) {
                    throw ValidationException::withMessages([
                        'items' => 'Ada alat yang tidak termasuk dalam transaksi peminjaman ini.',
                    ]);
                }

                if ($item['qty_kembali'] !== $detailPeminjaman->qty) {
                    throw ValidationException::withMessages([
                        'items' => "Jumlah pengembalian {$detailPeminjaman->alat->nama_alat} harus sama dengan jumlah pinjam.",
                    ]);
                }

                $pengembalian->details()->create($item);
            }

            if ($items->count() !== $peminjaman->details->count()) {
                throw ValidationException::withMessages([
                    'items' => 'Semua item pada transaksi peminjaman harus dikembalikan sekaligus.',
                ]);
            }

            if ($diterimaLangsung) {
                $this->applyAcceptedReturn($pengembalian);
            }

            ActivityLogger::log(
                $aktor,
                'Membuat pengembalian',
                $pengembalian,
                'Pengembalian alat berhasil dicatat.',
                [
                    'kode_peminjaman' => $peminjaman->kode_peminjaman,
                    'status' => $pengembalian->status,
                ],
            );

            return $pengembalian->load('details.alat', 'peminjaman.user', 'petugas');
        });
    }

    public function terima(Pengembalian $pengembalian, User $petugas, ?string $catatan = null): void
    {
        DB::transaction(function () use ($pengembalian, $petugas, $catatan) {
            $pengembalian->loadMissing('details.alat', 'peminjaman.user');

            if ($pengembalian->status !== 'diajukan') {
                throw ValidationException::withMessages([
                    'status' => 'Pengembalian ini sudah diproses.',
                ]);
            }

            $pengembalian->update([
                'diterima_oleh' => $petugas->id,
                'status' => 'diterima',
                'catatan' => $this->mergeCatatan($pengembalian->catatan, $catatan),
            ]);

            $this->applyAcceptedReturn($pengembalian);

            ActivityLogger::log(
                $petugas,
                'Menerima pengembalian',
                $pengembalian,
                'Pengembalian diverifikasi dan diterima.',
                ['kode_peminjaman' => $pengembalian->peminjaman->kode_peminjaman],
            );
        });
    }

    private function applyAcceptedReturn(Pengembalian $pengembalian): void
    {
        $pengembalian->loadMissing('details.alat', 'peminjaman');

        foreach ($pengembalian->details as $detail) {
            $alat = Alat::findOrFail($detail->alat_id);
            $alat->stok_tersedia += $detail->qty_kembali;
            $alat->status = 'Tersedia';
            $alat->save();
        }

        $pengembalian->peminjaman->update([
            'status' => 'dikembalikan',
        ]);
    }

    private function calculateFine(Peminjaman $peminjaman, string $tanggalKembali): array
    {
        $dueDate = Carbon::parse($peminjaman->tanggal_rencana_kembali)->startOfDay();
        $returnDate = Carbon::parse($tanggalKembali)->startOfDay();
        $hariTerlambat = $returnDate->greaterThan($dueDate) ? $dueDate->diffInDays($returnDate) : 0;

        return [$hariTerlambat, $hariTerlambat * self::DENDA_PER_HARI];
    }

    private function mergeCatatan(?string $existing, ?string $extra): ?string
    {
        $notes = collect([$existing, $extra])
            ->filter(fn (?string $note) => filled($note))
            ->implode(PHP_EOL);

        return $notes !== '' ? $notes : null;
    }
}
