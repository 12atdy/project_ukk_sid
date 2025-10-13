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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Ini cara standar Laravel membuat ID
            $table->string('name'); // <-- KOLOM INI WAJIB UNTUK BREEZE
            $table->string('email')->unique(); // <-- KOLOM INI WAJIB UNTUK BREEZE
            $table->timestamp('email_verified_at')->nullable(); // <-- Ini juga untuk Breeze
            $table->string('password'); // Ini sudah benar
            
            $table->string('username')->unique()->nullable(); // Kita buat bisa dikosongi untuk sementara
            $table->enum('role', ['admin', 'warga'])->default('warga'); // Kita beri nilai default 'warga'
            $table->foreignId('biodata_id')->nullable(); // Relasi ke biodata

            $table->rememberToken(); // <-- Ini juga wajib untuk Breeze
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
