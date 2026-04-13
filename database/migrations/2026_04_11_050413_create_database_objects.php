<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        DB::unprepared('DROP PROCEDURE IF EXISTS sp_setujui_peminjaman');
        DB::unprepared('DROP FUNCTION IF EXISTS fn_hitung_denda');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_pengembalian_after_insert');

        DB::unprepared(<<<'SQL'
            CREATE FUNCTION fn_hitung_denda(p_jatuh_tempo DATE, p_tanggal_kembali DATE)
            RETURNS DECIMAL(12,2)
            DETERMINISTIC
            BEGIN
                DECLARE v_hari_terlambat INT DEFAULT 0;

                IF p_tanggal_kembali > p_jatuh_tempo THEN
                    SET v_hari_terlambat = DATEDIFF(p_tanggal_kembali, p_jatuh_tempo);
                END IF;

                RETURN v_hari_terlambat * 5000;
            END
        SQL);

        DB::unprepared(<<<'SQL'
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
            END
        SQL);

        DB::unprepared(<<<'SQL'
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
            END
        SQL);
    }

    public function down(): void
    {
        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        DB::unprepared('DROP TRIGGER IF EXISTS trg_pengembalian_after_insert');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_setujui_peminjaman');
        DB::unprepared('DROP FUNCTION IF EXISTS fn_hitung_denda');
    }
};
