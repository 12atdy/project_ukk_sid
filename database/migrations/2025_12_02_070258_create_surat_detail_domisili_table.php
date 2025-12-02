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
        Schema::create('surat_detail_domisili', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ajuan_id')->unique()->constrained('surat_ajuan')->onDelete('cascade');
            
            // Detail Kepindahan
            $table->text('alamat_asal');      // Kota A (Sidoarjo)
            $table->text('alamat_tujuan');    // Kota B (Jakarta)
            $table->string('alasan_pindah')->nullable(); // Misal: Pekerjaan / Pendidikan
            $table->integer('jumlah_pengikut')->default(0); // Sendiri atau bawa keluarga
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_detail_domisili');
    }
};