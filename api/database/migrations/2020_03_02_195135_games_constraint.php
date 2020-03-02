<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GamesConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['winner']);
            $table->foreign('winner')->references('id')->on('players')->onDelete('set null');
        });
    
        Schema::table('game_performance', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropForeign(['performance_id']);
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('performance_id')->references('id')->on('performances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['winner']);

            $table->foreign('winner')->references('id')->on('players')->onDelete('no action');
            
        });
        Schema::table('game_performance', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropForeign(['performance_id']);

            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('performance_id')->references('id')->on('performances');
        });
    }
}
