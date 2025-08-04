<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus constraint lama
        DB::statement('ALTER TABLE users DROP CONSTRAINT users_status_check');

        // Tambahkan constraint baru dengan nilai yang diperbarui
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('pending', 'approved', 'rejected', 'disabled'))");
    }

    public function down(): void
    {
        // Kembalikan constraint lama untuk rollback
        DB::statement('ALTER TABLE users DROP CONSTRAINT users_status_check');
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('pending', 'approved', 'rejected'))");
    }
};
