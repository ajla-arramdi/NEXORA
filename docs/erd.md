# ERD Sederhana Aplikasi Peminjaman Alat

## Entitas utama

- `users`
  - id
  - name
  - email
  - password
  - role

- `kategoris`
  - id
  - nama
  - deskripsi

- `alats`
  - id
  - kategori_id
  - kode_alat
  - nama_alat
  - stok_total
  - stok_tersedia
  - kondisi
  - lokasi
  - status
  - deskripsi

- `peminjamans`
  - id
  - kode_peminjaman
  - user_id
  - petugas_id
  - tanggal_pinjam
  - tanggal_rencana_kembali
  - status
  - catatan
  - approved_at

- `peminjaman_details`
  - id
  - peminjaman_id
  - alat_id
  - qty
  - kondisi_keluar
  - catatan

- `pengembalians`
  - id
  - peminjaman_id
  - diterima_oleh
  - tanggal_kembali
  - status
  - hari_terlambat
  - denda
  - catatan

- `pengembalian_details`
  - id
  - pengembalian_id
  - alat_id
  - qty_kembali
  - kondisi_masuk
  - catatan

- `log_aktivitas`
  - id
  - user_id
  - aktivitas
  - entitas
  - entitas_id
  - deskripsi
  - metadata
  - created_at

## Relasi

- Satu `kategori` memiliki banyak `alat`
- Satu `user` (peminjam) memiliki banyak `peminjaman`
- Satu `user` (petugas) dapat menyetujui banyak `peminjaman`
- Satu `peminjaman` memiliki banyak `peminjaman_detail`
- Satu `peminjaman` memiliki satu `pengembalian`
- Satu `pengembalian` memiliki banyak `pengembalian_detail`
- Satu `user` memiliki banyak `log_aktivitas`
