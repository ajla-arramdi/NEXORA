-- Export dasar database MySQL/MariaDB untuk tugas Peminjaman Alat
-- Jalankan setelah tabel inti dibuat oleh migration Laravel.

DROP FUNCTION IF EXISTS fn_hitung_denda;
DELIMITER $$
CREATE FUNCTION fn_hitung_denda(p_jatuh_tempo DATE, p_tanggal_kembali DATE)
RETURNS DECIMAL(12,2)
DETERMINISTIC
BEGIN
    DECLARE v_hari_terlambat INT DEFAULT 0;

    IF p_tanggal_kembali > p_jatuh_tempo THEN
        SET v_hari_terlambat = DATEDIFF(p_tanggal_kembali, p_jatuh_tempo);
    END IF;

    RETURN v_hari_terlambat * 5000;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_setujui_peminjaman;
DELIMITER $$
CREATE PROCEDURE sp_setujui_peminjaman(
    IN p_peminjaman_id BIGINT,
    IN p_petugas_id BIGINT,
    IN p_catatan TEXT
)
BEGIN
    UPDATE peminjamans
    SET petugas_id = p_petugas_id,
        status = 'disetujui',
        approved_at = NOW(),
        catatan = COALESCE(p_catatan, catatan),
        updated_at = NOW()
    WHERE id = p_peminjaman_id
      AND status = 'diajukan';
END $$
DELIMITER ;

DROP TRIGGER IF EXISTS trg_pengembalian_after_insert;
DELIMITER $$
CREATE TRIGGER trg_pengembalian_after_insert
AFTER INSERT ON pengembalians
FOR EACH ROW
BEGIN
    INSERT INTO log_aktivitas (user_id, aktivitas, entitas, entitas_id, deskripsi, created_at)
    VALUES (
        NEW.diterima_oleh,
        'Trigger pengembalian',
        'Pengembalian',
        NEW.id,
        CONCAT('Trigger otomatis mencatat pengembalian untuk peminjaman ID ', NEW.peminjaman_id),
        NOW()
    );
END $$
DELIMITER ;

-- Seed akun demo (password bcrypt untuk kata sandi: password)
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES
('Administrator', 'admin@peminjaman.test', '$2y$10$.YCg7jurShNjt9a5asJZ3OJO.uoLu6IL90rVkII1RI6yxj6GgnqK2', 'admin', NOW(), NOW()),
('Petugas Lab', 'petugas@peminjaman.test', '$2y$10$.YCg7jurShNjt9a5asJZ3OJO.uoLu6IL90rVkII1RI6yxj6GgnqK2', 'petugas', NOW(), NOW()),
('Rifky Peminjam', 'peminjam@peminjaman.test', '$2y$10$.YCg7jurShNjt9a5asJZ3OJO.uoLu6IL90rVkII1RI6yxj6GgnqK2', 'peminjam', NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = VALUES(updated_at);
