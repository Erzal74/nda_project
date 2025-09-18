<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Hapus foreign key constraints dari tabel lain yang bergantung pada id
        Schema::table('ndas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('nda_user', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        // 2. Tambahkan kolom no sebagai nullable terlebih dahulu
        Schema::table('users', function (Blueprint $table) {
            $table->string('no')->nullable()->after('id');
        });

        // 3. Isi kolom no dengan nilai dari id
        DB::statement('UPDATE users SET no = id::text');

        // 4. Hapus kolom id dan jadikan no sebagai primary key
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        DB::statement('ALTER TABLE users ALTER COLUMN no SET NOT NULL');
        DB::statement('ALTER TABLE users ADD PRIMARY KEY (no)');

        // 5. Ubah tipe data user_id di tabel terkait menjadi string
        DB::statement('ALTER TABLE ndas ALTER COLUMN user_id TYPE VARCHAR(255) USING user_id::text');
        DB::statement('ALTER TABLE nda_user ALTER COLUMN user_id TYPE VARCHAR(255) USING user_id::text');

        // 6. Tambahkan kembali foreign key dengan merujuk ke no
        Schema::table('ndas', function (Blueprint $table) {
            $table->foreign('user_id')->references('no')->on('users')->onDelete('cascade');
        });

        Schema::table('nda_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('no')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // 1. Hapus foreign key yang merujuk ke no
        Schema::table('ndas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('nda_user', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        // 2. Ubah tipe data user_id kembali ke bigint
        DB::statement('ALTER TABLE ndas ALTER COLUMN user_id TYPE BIGINT USING user_id::bigint');
        DB::statement('ALTER TABLE nda_user ALTER COLUMN user_id TYPE BIGINT USING user_id::bigint');

        // 3. Drop primary key constraint dari no
        DB::statement('ALTER TABLE users DROP CONSTRAINT users_pkey');

        // 4. Tambahkan kembali kolom id
        Schema::table('users', function (Blueprint $table) {
            $table->id()->first();
        });

        // 5. Hapus kolom no
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('no');
        });

        // 6. Tambahkan kembali foreign key ke id
        Schema::table('ndas', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('nda_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
