<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('voted_player_id');
            $table->unsignedBigInteger('performance_id');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('voted_player_id')->references('id')->on('players');
            $table->foreign('performance_id')->references('id')->on('performances');
            $table->index(['game_id', 'player_id', 'performance_id', 'voted_player_id']);
            $table->primary(['game_id', 'player_id', 'performance_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
