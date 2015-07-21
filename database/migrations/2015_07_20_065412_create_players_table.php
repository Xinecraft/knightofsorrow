<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('ingame_id');
            $table->string('name');
            $table->integer('game_id')->unsigned();
            $table->integer('alias_id')->unsigned();
            $table->integer('loadout_id')->unsigned();
            $table->string('ip_address')->nullable();
            $table->integer('country_id')->unsigned();
            $table->smallInteger('team')->default(0);
            $table->boolean('is_admin')->default(0);
            $table->boolean('is_dropped')->default(0);
            $table->integer('score')->default(0);
            $table->integer('time_played');
            $table->integer('kills')->default(0);
            $table->integer('team_kills')->default(0);
            $table->integer('deaths')->default(0);
            $table->integer('suicides')->default(0);
            $table->integer('arrests')->default(0);
            $table->integer('arrested')->default(0);
            $table->integer('kill_streak')->default(0);
            $table->integer('arrest_streak')->default(0);
            $table->integer('death_streak')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('players');
    }
}
