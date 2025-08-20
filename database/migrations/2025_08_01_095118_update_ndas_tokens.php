<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;
use App\Models\Nda;

return new class extends Migration
{
    public function up(): void
    {
        // Hanya perbarui baris yang belum memiliki token dengan UUID baru
        Nda::whereNull('token')->get()->each(function ($nda) {
            $nda->update(['token' => Str::uuid()]);
        });
    }

    public function down(): void
    {
        // Tidak ada tindakan rollback yang diperlukan untuk ini
    }
};
