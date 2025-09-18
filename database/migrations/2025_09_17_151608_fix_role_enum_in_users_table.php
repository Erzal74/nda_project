<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus constraint lama jika ada
        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');

        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom role lama
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            // Tambah ulang kolom role dengan enum yang benar
            $table->enum('role', ['admin', 'pegawai'])->default('pegawai')->after('nip');
        });
    }

    public function down(): void
    {
        // Rollback ke definisi lama (admin, employee)
        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'employee'])->default('employee')->after('nip');
        });
    }
};
