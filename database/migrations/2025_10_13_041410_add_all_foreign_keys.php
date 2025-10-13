<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('biodata_id')->references('id')->on('biodata')->onDelete('set null');
        });
        Schema::table('berita', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('keuangan', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('log_aktivitas', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('penerima_bantuan', function (Blueprint $table) {
            $table->foreign('biodata_id')->references('id')->on('biodata')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('program_bantuan')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('surat_ajuan', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('surat_detail_usaha', function (Blueprint $table) {
            $table->foreign('ajuan_id')->references('id')->on('surat_ajuan')->onDelete('cascade');
        });
        Schema::table('surat_detail_nikah', function (Blueprint $table) {
            $table->foreign('ajuan_id')->references('id')->on('surat_ajuan')->onDelete('cascade');
        });
        Schema::table('surat_detail_tanah', function (Blueprint $table) {
            $table->foreign('ajuan_id')->references('id')->on('surat_ajuan')->onDelete('cascade');
            $table->foreign('biodata_id')->references('id')->on('biodata')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        Schema::table('tanggapan_pengaduan', function (Blueprint $table) {
            $table->foreign('pengaduan_id')->references('id')->on('pengaduan')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // ... (Tidak perlu diisi untuk sekarang, karena kita pakai migrate:fresh)
    }
};