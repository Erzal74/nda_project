<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ndas', function (Blueprint $table) {
            // Cek apakah kolom-kolom lama ada sebelum menghapus
            if (Schema::hasColumn('ndas', 'author')) {
                $table->dropColumn('author');
            }
            if (Schema::hasColumn('ndas', 'publisher')) {
                $table->dropColumn('publisher');
            }
            if (Schema::hasColumn('ndas', 'publication_year')) {
                $table->dropColumn('publication_year');
            }
            if (Schema::hasColumn('ndas', 'genre')) {
                $table->dropColumn('genre');
            }
            if (Schema::hasColumn('ndas', 'isbn')) {
                $table->dropColumn('isbn');
            }
            if (Schema::hasColumn('ndas', 'issn')) {
                $table->dropColumn('issn');
            }
            if (Schema::hasColumn('ndas', 'edition')) {
                $table->dropColumn('edition');
            }
        });

        Schema::table('ndas', function (Blueprint $table) {
            // Ubah nama kolom title menjadi project_name jika title ada
            if (Schema::hasColumn('ndas', 'title')) {
                $table->renameColumn('title', 'project_name');
            }

            // Tambah kolom-kolom baru untuk manajemen proyek jika belum ada
            if (!Schema::hasColumn('ndas', 'start_date')) {
                $table->date('start_date')->after('project_name');
            }
            if (!Schema::hasColumn('ndas', 'end_date')) {
                $table->date('end_date')->after('start_date');
            }
            if (!Schema::hasColumn('ndas', 'project_duration')) {
                $table->integer('project_duration')->nullable()->after('end_date');
            }
            if (!Schema::hasColumn('ndas', 'nda_signature_date')) {
                $table->date('nda_signature_date')->after('project_duration');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ndas', function (Blueprint $table) {
            // Kembalikan perubahan
            if (Schema::hasColumn('ndas', 'project_name')) {
                $table->renameColumn('project_name', 'title');
            }

            // Hapus kolom baru
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
        });

        Schema::table('ndas', function (Blueprint $table) {
            // Tambahkan kembali kolom lama
            $table->string('author')->nullable()->after('title');
            $table->string('publisher')->nullable()->after('author');
            $table->year('publication_year')->nullable()->after('publisher');
            $table->string('genre')->nullable()->after('publication_year');
            $table->string('isbn', 13)->nullable()->after('genre');
            $table->string('issn', 8)->nullable()->after('isbn');
            $table->string('edition')->nullable()->after('issn');
        });
    }
};
