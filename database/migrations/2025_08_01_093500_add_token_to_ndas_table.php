<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ndas', function (Blueprint $table) {
            $table->string('token')->unique()->nullable()->after('file_path');
        });

        // Generate token untuk NDA yang sudah ada
        \App\Models\Nda::all()->each(function ($nda) {
            if (!$nda->token) {
                $nda->update(['token' => \Illuminate\Support\Str::uuid()]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('ndas', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
};
