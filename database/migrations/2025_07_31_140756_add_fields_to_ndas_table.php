<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ndas', function (Blueprint $table) {
            // Hapus kolom-kolom lama yang tidak diperlukan
            $table->dropColumn([
                'author',
                'publisher',
                'publication_year',
                'genre',
                'isbn',
                'issn',
                'edition'
            ]);

            // Ubah nama kolom title menjadi project_name
            $table->renameColumn('title', 'project_name');

            // Tambah kolom-kolom baru untuk manajemen proyek
            $table->date('start_date')->after('project_name');
            $table->date('end_date')->after('start_date');
            $table->integer('project_duration')->nullable()->after('end_date'); // dalam hari
            $table->date('nda_signature_date')->after('project_duration');
        });
    }

    public function down(): void
    {
        Schema::table('ndas', function (Blueprint $table) {
            // Kembalikan perubahan
            $table->renameColumn('project_name', 'title');

            // Hapus kolom baru
            $table->dropColumn([
                'start_date',
                'end_date',
                'project_duration',
                'nda_signature_date'
            ]);

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
