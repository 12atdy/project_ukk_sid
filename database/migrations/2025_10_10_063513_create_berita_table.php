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
        Schema::create('berita', function (Blueprint $table) {
            $table->id(); // Menggunakan standar Laravel (tipe BIGINT)
            $table->string('judul');
            $table->text('isi')->nullable();
            $table->date('tanggal')->nullable();

            // Ini bagian yang diperbaiki untuk menyambung ke tabel users
            // Menggunakan foreignId agar tipe datanya cocok
            $table->foreignId('user_id')->nullable();

            $table->timestamps(); // Cara singkat untuk created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
