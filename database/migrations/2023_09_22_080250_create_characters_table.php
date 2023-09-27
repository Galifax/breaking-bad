<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->date('birthday');
            $table->json('occupations');
            $table->string('img', 100);
            $table->string('nickname', 50);
            $table->string('portrayed', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
}
