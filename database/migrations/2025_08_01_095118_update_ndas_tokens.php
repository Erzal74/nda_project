<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        \App\Models\Nda::whereNull('token')->get()->each(function ($nda) {
            $nda->update(['token' => Str::uuid()]);
        });
    }

    public function down(): void
    {
        // No rollback needed for token updates
    }
};
