<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag')->unique();
            $table->bigInteger('server_time');
            $table->integer('round_time');
            $table->smallInteger('gametype')->default(0);
            $table->smallInteger('outcome')->default(0);
            $table->smallInteger('map_id')->nullable();
            $table->smallInteger('total_players')->default(0);
            $table->smallInteger('swat_score')->default(0);
            $table->smallInteger('suspects_score')->default(0);
            $table->smallInteger('swat_vict')->nullable()->default(0);
            $table->smallInteger('suspects_vict')->nullable()->default(0);
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
        Schema::drop('games');
    }
}
