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
        Schema::create('surat_detail_kelahiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ajuan_id')->unique()->constrained('surat_ajuan')->onDelete('cascade');
            
            // Data Anak
            $table->string('nama_bayi');
            $table->string('jenis_kelamin_bayi'); // Laki-laki / Perempuan
            $table->string('tempat_lahir_bayi');
            $table->date('tanggal_lahir_bayi');
            $table->string('jam_lahir')->nullable();
            $table->integer('anak_ke')->nullable();
            
            // Data Orang Tua
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            
            // Opsional: Pelapor
            $table->string('hubungan_pelapor')->default('Orang Tua'); 
            
            $table->timestamps(); // Opsional, boleh ada boleh tidak
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_detail_kelahiran');
    }
};