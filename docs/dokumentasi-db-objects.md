# Dokumentasi Function, Procedure, dan Trigger

## 1. Function `fn_hitung_denda`
Digunakan untuk menghitung nominal denda berdasarkan selisih tanggal jatuh tempo dan tanggal kembali.

Rumus:
- jika telat = `DATEDIFF(tanggal_kembali, jatuh_tempo)`
- denda = telat x 5000

## 2. Stored Procedure `sp_setujui_peminjaman`
Digunakan untuk mengubah status transaksi peminjaman dari `diajukan` menjadi `disetujui` oleh petugas/admin.

Parameter:
- `p_peminjaman_id`
- `p_petugas_id`
- `p_catatan`

## 3. Trigger `trg_pengembalian_after_insert`
Dipanggil otomatis setelah data pengembalian disimpan. Trigger ini menambahkan jejak ke tabel `log_aktivitas`.

## 4. Commit / Rollback
Pada level aplikasi Laravel, proses berikut dibungkus transaction:
- create peminjaman + detail
- approve peminjaman + update stok
- create pengembalian + update stok

Jika salah satu operasi gagal, seluruh perubahan pada transaksi tersebut dibatalkan (rollback).
