<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditGamePlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_player', function (Blueprint $table) {
            $table->dropColumn('step');
            $table->dropColumn('question');
            $table->boolean('winner2')->default(false);
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
            $table->integer('step')->default(0);
            $table->integer('question')->default(0);
            $table->dropColumn('winner2');

        });
    }
}
