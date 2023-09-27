<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->mediumText('quote');
            $table->foreignId('episode_id')
                ->references('id')
                ->on('episodes')
                ->cascadeOnDelete();
            $table->foreignId('character_id')
                ->references('id')
                ->on('characters')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
}
