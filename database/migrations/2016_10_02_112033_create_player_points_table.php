<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_points', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();                         // Name of Player
            $table->integer('player_total_id')->unsigned()->nullable(); //player_total_id and name is same.
            $table->integer('points')->default(0);
            $table->integer('k_tournament_id')->unsigned()->nullable(); // If points given coz of tourny
            $table->text('reason')->nullable();
            $table->integer('admin_id')->unsigned();
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
        Schema::drop('player_points');
    }
}
