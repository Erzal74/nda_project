<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nda_files', function (Blueprint $table) {
            $table->date('signature_date')->nullable()->after('file_path'); // Tambah field baru per file/anggota
        });
    }

    public function down(): void
    {
        Schema::table('nda_files', function (Blueprint $table) {
            $table->dropColumn('signature_date');
        });
    }
};
