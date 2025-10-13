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
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id(); // Menggunakan standar Laravel (BIGINT)
            $table->string('kode_transaksi')->unique();
            $table->enum('jenis_transaksi', ['Pemasukan', 'Pengeluaran']);
            $table->text('keterangan');
            $table->string('sumber_penerima');
            $table->decimal('jumlah', 15, 2); // Menggunakan decimal untuk nominal uang
            $table->date('tanggal_transaksi');
            $table->string('penanggung_jawab');
            $table->string('bukti')->nullable();

            // Ini bagian yang diperbaiki (hanya membuat kolom)
            $table->foreignId('user_id')->nullable();

            $table->timestamps(); // Cara singkat untuk created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
