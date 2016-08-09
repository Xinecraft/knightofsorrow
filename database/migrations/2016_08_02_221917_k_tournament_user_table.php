<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KTournamentUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k_tournament_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            /**
             * 0 -> Pending Approval
             * 1 -> Not eligible
             * 2 -> Disqualified
             * 3 -> Approved to team as Member
             * 4 -> Approved to team as Admin
             */
            $table->integer('user_status')->default(0); // Pending.
            $table->integer('k_tournament_id')->unsigned();
            $table->integer('k_team_id')->unsigned()->nullable();
            $table->integer('total_score')->nullable();
            $table->integer('user_position')->nullable();
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
        Schema::drop('k_tournament_user');
    }
}
