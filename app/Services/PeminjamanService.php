<?php

namespace App\Services;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use App\Support\ActivityLogger;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PeminjamanService
{
    public function create(array $validated, User $user): Peminjaman
    {
        $items = collect($validated['items'] ?? [])
            ->map(fn (array $item) => [
                'alat_id' => (int) $item['alat_id'],
                'qty' => (int) ($item['qty'] ?? 0),
            ])
            ->filter(fn (array $item) => $item['qty'] > 0)
            ->values();

        if ($items->isEmpty()) {
            throw ValidationException::withMessages([
                'items' => 'Pilih minimal satu alat dengan jumlah lebih dari 0.',
            ]);
        }

        return DB::transaction(function () use ($validated, $user, $items) {
            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $this->generateCode(),
                'user_id' => $user->id,
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_rencana_kembali' => $validated['tanggal_rencana_kembali'],
                'status' => 'diajukan',
                'catatan' => $validated['catatan'] ?? null,
            ]);

            $this->createDetails($peminjaman, $items);

            ActivityLogger::log(
                $user,
                'Mengajukan peminjaman',
                $peminjaman,
                'Peminjaman baru diajukan.',
                ['kode_peminjaman' => $peminjaman->kode_peminjaman],
            );

            return $peminjaman->load('details.alat', 'user');
        });
    }

    public function approve(Peminjaman $peminjaman, User $petugas, ?string $catatan = null): void
    {
        DB::transaction(function () use ($peminjaman, $petugas, $catatan) {
            $peminjaman->loadMissing('details.alat', 'user');

            if ($peminjaman->status !== 'diajukan') {
                throw ValidationException::withMessages([
                    'status' => 'Peminjaman ini tidak bisa disetujui lagi.',
                ]);
            }

            foreach ($peminjaman->details as $detail) {
                $alat = Alat::findOrFail($detail->alat_id);

                if ($detail->qty > $alat->stok_tersedia) {
                    throw ValidationException::withMessages([
                        'stok' => "Stok alat {$alat->nama_alat} tidak mencukupi.",
                    ]);
                }

                $alat->stok_tersedia -= $detail->qty;
                $alat->status = $alat->stok_tersedia > 0 ? 'Tersedia' : 'Dipinjam';
                $alat->save();
            }

            $peminjaman->update([
                'petugas_id' => $petugas->id,
                'status' => 'disetujui',
                'approved_at' => now(),
                'catatan' => $this->mergeCatatan($peminjaman->catatan, $catatan),
            ]);

            ActivityLogger::log(
                $petugas,
                'Menyetujui peminjaman',
                $peminjaman,
                'Peminjaman disetujui oleh petugas.',
                [
                    'kode_peminjaman' => $peminjaman->kode_peminjaman,
                    'peminjam' => $peminjaman->user?->name,
                ],
            );
        });
    }

    public function reject(Peminjaman $peminjaman, User $petugas, ?string $catatan = null): void
    {
        if ($peminjaman->status !== 'diajukan') {
            throw ValidationException::withMessages([
                'status' => 'Peminjaman ini tidak bisa ditolak lagi.',
            ]);
        }

        $peminjaman->update([
            'petugas_id' => $petugas->id,
            'status' => 'ditolak',
            'approved_at' => now(),
            'catatan' => $this->mergeCatatan($peminjaman->catatan, $catatan),
        ]);

        ActivityLogger::log(
            $petugas,
            'Menolak peminjaman',
            $peminjaman,
            'Peminjaman ditolak oleh petugas.',
            ['kode_peminjaman' => $peminjaman->kode_peminjaman],
        );
    }

    private function createDetails(Peminjaman $peminjaman, Collection $items): void
    {
        foreach ($items as $item) {
            $alat = Alat::findOrFail($item['alat_id']);

            if ($item['qty'] > $alat->stok_tersedia) {
                throw ValidationException::withMessages([
                    'stok' => "Permintaan {$alat->nama_alat} melebihi stok tersedia.",
                ]);
            }

            $peminjaman->details()->create([
                'alat_id' => $alat->id,
                'qty' => $item['qty'],
                'kondisi_keluar' => $alat->kondisi,
            ]);
        }
    }

    private function generateCode(): string
    {
        $today = now();
        $counter = Peminjaman::whereDate('created_at', $today->toDateString())->count() + 1;

        return 'PJM-'.$today->format('Ymd').'-'.str_pad((string) $counter, 3, '0', STR_PAD_LEFT);
    }

    private function mergeCatatan(?string $existing, ?string $extra): ?string
    {
        $notes = collect([$existing, $extra])
            ->filter(fn (?string $note) => filled($note))
            ->implode(PHP_EOL);

        return $notes !== '' ? $notes : null;
    }
}
