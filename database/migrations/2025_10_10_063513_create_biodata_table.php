<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biodata', function (Blueprint $table) {
            $table->id();
            
            // [INI YANG DITAMBAHKAN] Kolom Penghubung ke User
            // Supaya sistem tahu biodata ini milik siapa
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('nik')->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat');
            $table->string('pekerjaan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biodata');
    }
};