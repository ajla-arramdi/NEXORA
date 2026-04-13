# Deskripsi Program

Aplikasi ini adalah sistem informasi peminjaman alat berbasis Laravel yang dibuat untuk memenuhi tugas pengembangan aplikasi RPL. Sistem mendukung tiga role pengguna, yaitu:

- **Admin**: mengelola user, master data, log aktivitas, dan laporan
- **Petugas**: mengelola data alat/kategori, menyetujui peminjaman, dan menerima pengembalian
- **Peminjam**: melihat alat tersedia, mengajukan peminjaman, dan membuat pengajuan pengembalian

Fitur utama meliputi:
- autentikasi login/logout
- CRUD user
- CRUD kategori
- CRUD alat
- transaksi peminjaman
- transaksi pengembalian
- log aktivitas
- laporan cetak

Proses bisnis penting dibungkus dengan transaksi database (`DB::transaction`) untuk memastikan data konsisten saat create, approve, dan return.
