<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ndas', function (Blueprint $table) {
            $table->dropColumn('nda_signature_date'); // Hapus field lama
        });
    }

    public function down(): void
    {
        Schema::table('ndas', function (Blueprint $table) {
            $table->date('nda_signature_date')->nullable(); // Restore jika rollback
        });
    }
};
