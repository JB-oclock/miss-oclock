<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamePerformanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_performance', function (Blueprint $table) {
            $table->timestamps();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('performance_id');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('performance_id')->references('id')->on('performances');
            $table->index(['game_id', 'performance_id']);
            $table->primary(['game_id', 'performance_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_performance');
    }
}
