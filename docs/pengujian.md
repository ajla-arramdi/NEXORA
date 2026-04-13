# Checklist Pengujian

## 1. Login User
- Akses halaman login
- Masukkan akun admin/petugas/peminjam
- Pastikan berhasil masuk ke dashboard
- Cek log aktivitas login tercatat

## 2. Tambah Alat
- Login sebagai admin atau petugas
- Buka menu Alat
- Tambah data alat baru
- Pastikan data tampil di tabel alat

## 3. Pinjam Alat
- Login sebagai peminjam
- Buka menu Peminjaman
- Isi form tanggal dan qty alat
- Pastikan transaksi tersimpan dengan status `diajukan`

## 4. Setujui Peminjaman
- Login sebagai admin/petugas
- Buka daftar peminjaman
- Klik setujui
- Pastikan status berubah `disetujui` dan stok berkurang

## 5. Kembalikan Alat + Denda
- Buka menu Pengembalian
- Pilih transaksi yang sudah disetujui
- Isi tanggal kembali melebihi jatuh tempo
- Pastikan denda terhitung dan stok kembali bertambah

## 6. Cek Privilege User
- Admin dapat membuka menu user dan log aktivitas
- Petugas dapat membuka alat, kategori, laporan
- Peminjam tidak bisa membuka halaman admin/petugas (403)
