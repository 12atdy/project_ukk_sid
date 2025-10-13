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
    Schema::create('surat_detail_usaha', function (Blueprint $table) {
        $table->id();
        $table->foreignId('ajuan_id')->unique();
        $table->string('nama_usaha');
        $table->string('jenis_usaha')->nullable();
        $table->text('alamat_usaha');
        $table->year('dimulai_sejak')->nullable();
        // Hapus timestamps jika tidak diperlukan
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_detail_usaha');
    }
};
