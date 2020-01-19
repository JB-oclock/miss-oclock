<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('question_id');
            $table->text('answer');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->index(['game_id', 'player_id', 'question_id']);
            $table->primary(['game_id', 'player_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
