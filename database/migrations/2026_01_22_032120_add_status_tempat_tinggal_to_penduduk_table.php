<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('biodata', function (Blueprint $table) {
        // Menambahkan kolom status
        // Default kita set 'asli' (atau 'tetap')
        $table->enum('status_tempat_tinggal', ['asli', 'pendatang', 'musiman'])->default('asli')->after('alamat');
        
        // Opsional: Kolom untuk menyimpan bukti dokumen (path file)
        $table->string('file_bukti_domisili')->nullable()->after('status_tempat_tinggal');
    });
}

public function down()
{
    Schema::table('biodata', function (Blueprint $table) {
        $table->dropColumn(['status_tempat_tinggal', 'file_bukti_domisili']);
    });
}
};
