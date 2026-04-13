<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengembalian_id')->constrained('pengembalians')->cascadeOnDelete();
            $table->foreignId('alat_id')->constrained('alats')->restrictOnDelete();
            $table->unsignedInteger('qty_kembali');
            $table->string('kondisi_masuk')->default('Baik');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian_details');
    }
};
