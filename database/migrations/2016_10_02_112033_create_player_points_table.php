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
            $table->string('name');
            $table->integer('player_total_id')->unsigned(); //player_total_id and name is same.
            $table->integer('points');
            $table->text('reason');
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
