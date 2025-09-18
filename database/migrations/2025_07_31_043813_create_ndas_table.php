<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ndas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('token')->unique()->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Gunakan foreignId
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ndas');
    }
};
