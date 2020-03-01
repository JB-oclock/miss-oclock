<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->integer('performance_sent')->default(0)->change();
            $table->boolean('performance_props_sent')->default(0)->change();
            $table->integer('performance_player')->default(0)->change();
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
            $table->integer('performance_sent')->default(null)->change();
            $table->boolean('performance_props_sent')->default(null)->change();
            $table->integer('performance_player')->default(null)->change();

        });
    }
}
