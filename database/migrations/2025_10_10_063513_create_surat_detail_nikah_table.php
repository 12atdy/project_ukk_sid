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
    Schema::create('surat_detail_nikah', function (Blueprint $table) {
        $table->id();
        $table->foreignId('ajuan_id')->unique();
        $table->string('nama_calon_pasangan');
        $table->string('nik_calon_pasangan')->nullable();
        $table->string('tempat_lahir_calon')->nullable();
        $table->date('tanggal_lahir_calon')->nullable();
        $table->string('pekerjaan_calon')->nullable();
        $table->text('alamat_calon')->nullable();
        $table->string('tempat_acara_calon')->nullable();
        $table->string('status_perkawinan_calon')->nullable();
        // Hapus timestamps jika tidak diperlukan
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_detail_nikah');
    }
};
