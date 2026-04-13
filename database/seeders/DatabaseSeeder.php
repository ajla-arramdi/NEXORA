<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@peminjaman.test'],
            [
                'name' => 'Administrator',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'petugas@peminjaman.test'],
            [
                'name' => 'Petugas Lab',
                'password' => 'password',
                'role' => User::ROLE_PETUGAS,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'peminjam@peminjaman.test'],
            [
                'name' => 'Rifky Peminjam',
                'password' => 'password',
                'role' => User::ROLE_PEMINJAM,
            ],
        );

        $kategoriElektronik = Kategori::query()->updateOrCreate(
            ['nama' => 'Elektronik'],
            ['deskripsi' => 'Peralatan elektronik dan multimedia.'],
        );

        $kategoriAlat = Kategori::query()->updateOrCreate(
            ['nama' => 'Peralatan Praktik'],
            ['deskripsi' => 'Alat penunjang pembelajaran praktik.'],
        );

        Alat::query()->updateOrCreate(
            ['kode_alat' => 'ALT-001'],
            [
                'kategori_id' => $kategoriElektronik->id,
                'nama_alat' => 'Proyektor Epson',
                'stok_total' => 4,
                'stok_tersedia' => 4,
                'kondisi' => 'Baik',
                'lokasi' => 'Gudang A',
                'status' => 'Tersedia',
                'deskripsi' => 'Proyektor untuk kegiatan presentasi.',
            ],
        );

        Alat::query()->updateOrCreate(
            ['kode_alat' => 'ALT-002'],
            [
                'kategori_id' => $kategoriElektronik->id,
                'nama_alat' => 'Laptop Laboratorium',
                'stok_total' => 10,
                'stok_tersedia' => 10,
                'kondisi' => 'Baik',
                'lokasi' => 'Lab Komputer',
                'status' => 'Tersedia',
                'deskripsi' => 'Laptop untuk kegiatan praktik kelas.',
            ],
        );

        Alat::query()->updateOrCreate(
            ['kode_alat' => 'ALT-003'],
            [
                'kategori_id' => $kategoriAlat->id,
                'nama_alat' => 'Toolkit Jaringan',
                'stok_total' => 6,
                'stok_tersedia' => 6,
                'kondisi' => 'Baik',
                'lokasi' => 'Gudang B',
                'status' => 'Tersedia',
                'deskripsi' => 'Toolkit untuk keperluan instalasi jaringan.',
            ],
        );
    }
}
