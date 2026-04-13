# Flowchart Peminjaman Alat

```text
Mulai
  ↓
Peminjam memilih alat dan jumlah
  ↓
Validasi tanggal dan item
  ↓
Apakah ada item dipilih?
  ├─ Tidak → tampilkan error → selesai
  └─ Ya
        ↓
      Simpan peminjaman + detail dalam transaction
        ↓
      Status = diajukan
        ↓
      Petugas/Admin review pengajuan
        ↓
      Apakah disetujui?
        ├─ Tidak → status = ditolak → selesai
        └─ Ya
              ↓
            Kurangi stok alat
              ↓
            Status = disetujui
              ↓
            Simpan log aktivitas
              ↓
            Selesai
```
