<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeaponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weapons', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('name');
            $table->integer('player_id')->unsigned();
            $table->smallInteger('seconds_used');
            $table->smallInteger('shots_fired');
            $table->smallInteger('shots_hit');
            $table->smallInteger('shots_teamhit');
            $table->smallInteger('kills');
            $table->smallInteger('teamkills');
            $table->float('distance');
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
        Schema::drop('weapons');
    }
}
