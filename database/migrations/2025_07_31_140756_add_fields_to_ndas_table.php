<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ndas', function (Blueprint $table) {
            if (Schema::hasColumn('ndas', 'title')) {
                $table->renameColumn('title', 'project_name');
            }

            $table->date('start_date')->after('project_name')->nullable();
            $table->date('end_date')->after('start_date')->nullable();
            $table->integer('project_duration')->nullable()->after('end_date');
            $table->date('nda_signature_date')->after('project_duration')->nullable();
            // Hapus baris ini karena token sudah ada: $table->string('token')->unique()->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('ndas', function (Blueprint $table) {
            if (Schema::hasColumn('ndas', 'project_name')) {
                $table->renameColumn('project_name', 'title');
            }

            if (Schema::hasColumn('ndas', 'start_date')) {
                $table->dropColumn('start_date');
            }
            if (Schema::hasColumn('ndas', 'end_date')) {
                $table->dropColumn('end_date');
            }
            if (Schema::hasColumn('ndas', 'project_duration')) {
                $table->dropColumn('project_duration');
            }
            if (Schema::hasColumn('ndas', 'nda_signature_date')) {
                $table->dropColumn('nda_signature_date');
            }
            // Tidak perlu drop token karena tidak ditambahkan di sini
        });
    }
};
