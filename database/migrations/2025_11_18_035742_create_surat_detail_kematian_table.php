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
        Schema::create('surat_detail_kematian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ajuan_id')->unique()->constrained('surat_ajuan')->onDelete('cascade');
            
            // Data Almarhum
            $table->string('nama_almarhum');
            $table->string('nik_almarhum')->nullable();
            $table->string('bin_binti')->nullable();
            $table->string('tempat_lahir_almarhum')->nullable();
            $table->date('tanggal_lahir_almarhum')->nullable();
            
            // Data Kematian
            $table->date('tanggal_meninggal');
            $table->string('jam_meninggal')->nullable();
            $table->string('tempat_meninggal'); // Rumah Sakit / Rumah
            $table->text('sebab_meninggal'); // Sakit Tua / Kecelakaan
            
            // Info Tambahan
            $table->string('nama_pelapor')->nullable(); // Biasanya ahli waris
            $table->string('hubungan_pelapor')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_detail_kematian');
    }
};