<?php

namespace Tests\Feature;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeminjamanFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_peminjaman_and_pengembalian_flow_works(): void
    {
        $kategori = Kategori::create([
            'nama' => 'Elektronik Test',
            'deskripsi' => 'Kategori untuk pengujian.',
        ]);

        $alat = Alat::create([
            'kategori_id' => $kategori->id,
            'kode_alat' => 'ALT-TST-01',
            'nama_alat' => 'Laptop Test',
            'stok_total' => 5,
            'stok_tersedia' => 5,
            'kondisi' => 'Baik',
            'lokasi' => 'Lab Test',
            'status' => 'Tersedia',
        ]);

        $peminjam = User::factory()->create(['role' => User::ROLE_PEMINJAM]);
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($peminjam)
            ->post('/peminjaman', [
                'tanggal_pinjam' => '2026-04-10',
                'tanggal_rencana_kembali' => '2026-04-12',
                'catatan' => 'Dipakai presentasi proyek.',
                'items' => [
                    ['alat_id' => $alat->id, 'qty' => 2],
                ],
            ])
            ->assertRedirect(route('peminjaman.index', absolute: false));

        $peminjaman = Peminjaman::query()->firstOrFail();

        $this->assertDatabaseHas('peminjamans', [
            'id' => $peminjaman->id,
            'user_id' => $peminjam->id,
            'status' => 'diajukan',
        ]);

        $this->assertDatabaseHas('peminjaman_details', [
            'peminjaman_id' => $peminjaman->id,
            'alat_id' => $alat->id,
            'qty' => 2,
        ]);

        $this->actingAs($admin)
            ->post('/peminjaman/'.$peminjaman->id.'/process', [
                'action' => 'approve',
            ])
            ->assertRedirect(route('peminjaman.index', absolute: false));

        $this->assertDatabaseHas('peminjamans', [
            'id' => $peminjaman->id,
            'status' => 'disetujui',
            'petugas_id' => $admin->id,
        ]);

        $this->assertDatabaseHas('alats', [
            'id' => $alat->id,
            'stok_tersedia' => 3,
        ]);

        $this->actingAs($admin)
            ->post('/pengembalian', [
                'peminjaman_id' => $peminjaman->id,
                'tanggal_kembali' => '2026-04-13',
                'items' => [
                    [
                        'alat_id' => $alat->id,
                        'qty_kembali' => 2,
                        'kondisi_masuk' => 'Baik',
                    ],
                ],
            ])
            ->assertRedirect(route('pengembalian.index', absolute: false));

        $this->assertDatabaseHas('pengembalians', [
            'peminjaman_id' => $peminjaman->id,
            'status' => 'diterima',
            'hari_terlambat' => 1,
            'denda' => 5000,
        ]);

        $this->assertDatabaseHas('alats', [
            'id' => $alat->id,
            'stok_tersedia' => 5,
        ]);

        $this->assertDatabaseHas('peminjamans', [
            'id' => $peminjaman->id,
            'status' => 'dikembalikan',
        ]);
    }
}
