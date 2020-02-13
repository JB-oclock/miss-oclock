<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGamePlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_player', function (Blueprint $table) {
            $table->dropForeign('game_player_game_id_foreign');
            $table->dropForeign('game_player_player_id_foreign');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_player', function (Blueprint $table) {
            $table->dropForeign('game_player_game_id_foreign');
            $table->dropForeign('game_player_player_id_foreign');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('player_id')->references('id')->on('players');
        });
    }
}
