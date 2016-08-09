<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('photo_id')->unsigned()->nullable();
            $table->integer('k_tournament_id');
            $table->integer('k_group_id')->nullable();
            $table->integer('clan_id')->nullable();
            $table->boolean('teamclosed')->default(false);
            /**
             * 0 -> Pending Approval
             * 1 -> Approved
             * 2 -> Disqualified
             * 3 -> Not eligible
             */
            $table->integer('team_status')->default(0);
            $table->integer('total_score')->default(0);
            $table->integer('total_wins')->default(0);
            $table->integer('total_lost')->default(0);
            $table->integer('total_tie')->default(0);
            $table->integer('team_position')->nullable();
            $table->integer('points')->nullable();
            $table->float('rating')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('country_id')->unsigned()->default(243);    //United Nations
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
        Schema::drop('k_teams');
    }
}
