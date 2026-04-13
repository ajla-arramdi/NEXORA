# Catatan Debugging

## Temuan 1
Urutan nama file migration awal menyebabkan foreign key berpotensi tidak aman saat dipindah ke MySQL karena tabel referensi bisa belum dibuat lebih dulu.

### Solusi
Nama file migration diurutkan ulang sehingga relasi tabel berjalan aman:
- kategori -> alat
- peminjaman -> detail
- pengembalian -> detail

## Temuan 2
Seeder gagal jika dijalankan dua kali karena email user unik.

### Solusi
Seeder diubah menggunakan `updateOrCreate` agar idempotent.

## Temuan 3
Test Breeze default untuk register publik gagal karena route register sengaja dinonaktifkan.

### Solusi
Test `RegistrationTest` disesuaikan agar memverifikasi bahwa route register memang tidak tersedia untuk publik.
