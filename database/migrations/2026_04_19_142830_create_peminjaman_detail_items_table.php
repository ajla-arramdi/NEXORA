<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman_detail_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_detail_id')->constrained('peminjaman_details')->cascadeOnDelete();
            $table->foreignId('produk_item_id')->constrained('produk_items')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_detail_items');
    }
};
