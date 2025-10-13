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
    Schema::create('penerima_bantuan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('biodata_id')->nullable();
        $table->foreignId('program_id')->nullable();
        $table->foreignId('user_id')->nullable(); // User yang mendata
        $table->date('tanggal_penetapan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerima_bantuan');
    }
};
