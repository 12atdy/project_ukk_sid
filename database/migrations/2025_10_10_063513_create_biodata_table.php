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
        Schema::create('biodata', function (Blueprint $table) {
            $table->id();

            // WAJIB ADA: Relasi ke tabel users
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            $table->string('nik', 16)->unique();
            $table->string('nomor_kk', 16)->nullable(); // Tambahan kolom No KK
            $table->string('nama_lengkap');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable(); // Sesuaikan dengan seeder
            $table->string('agama')->nullable(); // Tambahan kolom Agama
            $table->string('status_perkawinan')->nullable(); // Di seeder 'Kawin', nanti kita sesuaikan
            $table->string('pekerjaan')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodata');
    }
};
