<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->unique()->constrained('peminjamans')->cascadeOnDelete();
            $table->foreignId('diterima_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal_kembali');
            $table->string('status')->default('diterima');
            $table->unsignedInteger('hari_terlambat')->default(0);
            $table->decimal('denda', 12, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
