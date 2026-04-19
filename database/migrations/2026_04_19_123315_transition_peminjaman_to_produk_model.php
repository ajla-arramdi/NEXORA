<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // To safely swap the core architecture, we clear current dummy transactions
        // that rely on legacy Alat IDs.
        Schema::disableForeignKeyConstraints();
        DB::table('pengembalian_details')->truncate();
        DB::table('pengembalians')->truncate();
        DB::table('peminjaman_details')->truncate();
        DB::table('peminjamans')->truncate();
        Schema::enableForeignKeyConstraints();

        Schema::table('peminjaman_details', function (Blueprint $table) {
            $table->dropForeign(['alat_id']);
            $table->renameColumn('alat_id', 'produk_id');
        });

        Schema::table('peminjaman_details', function (Blueprint $table) {
            $table->foreign('produk_id')->references('id')->on('produks')->restrictOnDelete();
        });

        Schema::table('pengembalian_details', function (Blueprint $table) {
            $table->dropForeign(['alat_id']);
            $table->renameColumn('alat_id', 'produk_id');
        });

        Schema::table('pengembalian_details', function (Blueprint $table) {
            $table->foreign('produk_id')->references('id')->on('produks')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pengembalian_details', function (Blueprint $table) {
            $table->dropForeign(['produk_id']);
            $table->renameColumn('produk_id', 'alat_id');
        });

        Schema::table('pengembalian_details', function (Blueprint $table) {
            $table->foreign('alat_id')->references('id')->on('alats')->restrictOnDelete();
        });

        Schema::table('peminjaman_details', function (Blueprint $table) {
            $table->dropForeign(['produk_id']);
            $table->renameColumn('produk_id', 'alat_id');
        });

        Schema::table('peminjaman_details', function (Blueprint $table) {
            $table->foreign('alat_id')->references('id')->on('alats')->restrictOnDelete();
        });
    }
};
