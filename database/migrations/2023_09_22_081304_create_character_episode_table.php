<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterEpisodeTable extends Migration
{
    public function up(): void
    {
        Schema::create('character_episode', function (Blueprint $table) {
            $table->foreignId('character_id')
                ->references('id')
                ->on('characters')
                ->cascadeOnDelete();
            $table->foreignId('episode_id')
                ->references('id')
                ->on('episodes')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('character_episode');
    }
}
