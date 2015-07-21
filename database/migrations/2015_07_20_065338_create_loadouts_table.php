<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoadoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loadouts', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('primary_weapon')->nullable();
            $table->smallInteger('primary_ammo')->nullable();
            $table->smallInteger('secondary_weapon')->nullable();
            $table->smallInteger('secondary_ammo')->nullable();
            $table->smallInteger('equip_one')->nullable();
            $table->smallInteger('equip_two')->nullable();
            $table->smallInteger('equip_three')->nullable();
            $table->smallInteger('equip_four')->nullable();
            $table->smallInteger('equip_five')->nullable();
            $table->smallInteger('breacher')->nullable();
            $table->smallInteger('head')->nullable();
            $table->smallInteger('body')->nullable();
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
        Schema::drop('loadouts');
    }
}
