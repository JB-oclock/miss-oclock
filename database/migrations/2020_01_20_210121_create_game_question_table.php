<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_question', function (Blueprint $table) {
            $table->timestamps();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->index(['game_id', 'question_id']);
            $table->primary(['game_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_question');
    }
}
