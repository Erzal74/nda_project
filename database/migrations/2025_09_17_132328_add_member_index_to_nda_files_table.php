<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nda_files', function (Blueprint $table) {
            $table->integer('member_index')->nullable()->after('nda_id'); // PERBAIKAN: Tambah kolom untuk link ke anggota (index dari array members)
        });
    }

    public function down(): void
    {
        Schema::table('nda_files', function (Blueprint $table) {
            $table->dropColumn('member_index');
        });
    }
};
