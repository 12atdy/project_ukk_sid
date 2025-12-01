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
    Schema::create('surat_ajuan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable(); // User yang mengajukan
        $table->string('jenis_surat');
        $table->string('nomor_surat')->nullable()->unique();
        $table->date('tanggal_ajuan');
        $table->string('foto_lampiran')->nullable();
        $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
        $table->text('keterangan_admin')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_ajuan');
    }
};
