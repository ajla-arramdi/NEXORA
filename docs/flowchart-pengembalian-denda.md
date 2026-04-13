# Flowchart Pengembalian dan Denda

```text
Mulai
  ↓
Pilih transaksi peminjaman aktif
  ↓
Input tanggal kembali dan kondisi barang
  ↓
Validasi seluruh item pengembalian
  ↓
Hitung hari terlambat
  ↓
Denda = hari terlambat x 5000
  ↓
Apakah diproses petugas/admin langsung?
  ├─ Ya
  │    ↓
  │  Simpan pengembalian
  │    ↓
  │  Tambah stok alat
  │    ↓
  │  Status peminjaman = dikembalikan
  │    ↓
  │  Simpan log aktivitas
  │    ↓
  │  Selesai
  └─ Tidak
       ↓
     Simpan pengajuan pengembalian
       ↓
     Tunggu verifikasi petugas
       ↓
     Jika diterima: tambah stok + tutup transaksi
       ↓
     Selesai
```
