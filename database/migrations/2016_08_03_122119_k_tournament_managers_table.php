<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KTournamentManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k_tournament_managers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('k_tournament_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('k_tournament_id')->references('id')->on('k_tournaments');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('k_tournament_managers');
    }
}
