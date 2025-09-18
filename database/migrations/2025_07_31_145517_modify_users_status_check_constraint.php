<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus constraint lama hanya jika ada
        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check');

        // Tambahkan constraint baru dengan nilai yang diperbarui
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('pending', 'approved', 'rejected', 'disabled'))");
    }

    public function down(): void
    {
        // Hapus constraint baru
        DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check');

        // Kembalikan constraint lama (jika diperlukan berdasarkan riwayat)
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('pending', 'approved', 'rejected'))");
    }
};
