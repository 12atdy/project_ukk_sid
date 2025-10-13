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
    Schema::create('surat_detail_tanah', function (Blueprint $table) {
        $table->id();
        $table->foreignId('ajuan_id')->unique();
        $table->foreignId('biodata_id')->nullable();
        $table->foreignId('user_id')->nullable(); // Petugas yang memverifikasi
        $table->string('keperluan')->nullable();
        $table->string('nomor_kohir')->nullable()->unique();
        $table->text('lokasi_tanah');
        $table->decimal('luas_tanah_m2', 10, 2)->nullable();
        $table->string('batas_utara')->nullable();
        $table->string('batas_timur')->nullable();
        $table->string('batas_selatan')->nullable();
        $table->string('batas_barat')->nullable();
        $table->text('riwayat_kepemilikan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_detail_tanah');
    }
};
