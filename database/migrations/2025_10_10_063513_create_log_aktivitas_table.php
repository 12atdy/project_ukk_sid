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
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id(); // Standar Laravel
            
            // Kolom foreign key dengan tipe data yang benar
            $table->foreignId('user_id')->nullable();

            $table->string('aktivitas');
            $table->timestamps(); // Menggantikan 'waktu' dengan created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
