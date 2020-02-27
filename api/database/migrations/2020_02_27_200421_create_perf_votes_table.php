<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perf_votes', function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('performer_id');
            $table->unsignedBigInteger('performance_id');
            $table->text('answer');
            $table->boolean('correct_answer');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('performer_id')->references('id')->on('players');
            $table->foreign('performance_id')->references('id')->on('performances');
            $table->index(['game_id', 'player_id', 'performance_id', 'performer_id']);
            $table->primary(['game_id', 'player_id', 'performance_id', 'performer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perf_votes');
    }
}
