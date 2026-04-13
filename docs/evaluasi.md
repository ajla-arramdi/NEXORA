# Evaluasi Singkat

## Fitur yang sudah berjalan
- Login/logout berbasis Laravel Breeze
- Dashboard berbeda berdasarkan role
- CRUD user, kategori, dan alat
- Pengajuan peminjaman alat
- Approval peminjaman oleh admin/petugas
- Pengembalian alat dan perhitungan denda
- Log aktivitas
- Laporan dan print view
- SQL object untuk procedure, function, dan trigger
- Automated test untuk akses role dan alur pinjam-kembali

## Bug / catatan yang masih mungkin dikembangkan
- SQL object MySQL/MariaDB belum bisa diverifikasi langsung di environment ini karena project masih memakai SQLite default
- UI masih fokus ke admin panel akademik, belum sampai export PDF native
- Pengembalian masih diasumsikan full return sekaligus, belum partial return

## Rencana pengembangan lanjutan
- Ganti koneksi database ke MySQL Laragon dan uji stored procedure/function/trigger langsung
- Tambah export PDF untuk laporan
- Tambah filter dan pencarian di semua tabel
- Tambah upload bukti atau foto kondisi alat
