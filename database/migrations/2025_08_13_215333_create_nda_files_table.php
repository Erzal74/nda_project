<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nda_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nda_id')->constrained()->onDelete('cascade'); // Relasi ke NDA
            $table->string('file_path'); // Path file PDF
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nda_files');
    }
};
