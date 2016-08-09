<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k_matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('k_tournament_id');
            $table->integer('k_round_id')->nullable();
            $table->integer('game1_id')->nullable();
            $table->integer('game2_id')->nullable();
            $table->integer('game3_id')->nullable();
            $table->integer('game4_id')->nullable();
            $table->integer('game5_id')->nullable();
            $table->integer('game6_id')->nullable();
            $table->integer('game1_id_outcome')->nullable();
            $table->integer('game2_id_outcome')->nullable();
            $table->integer('game3_id_outcome')->nullable();
            $table->integer('game4_id_outcome')->nullable();
            $table->integer('game5_id_outcome')->nullable();
            $table->integer('game6_id_outcome')->nullable();
            $table->integer('k_team1_id');
            $table->integer('k_team2_id');
            $table->integer('k_team1_total_score')->default(0);
            $table->integer('k_team2_total_score')->default(0);
            $table->integer('winner_team_id')->nullable();
            $table->string('winner_team_won_by')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->boolean('has_been_played')->default(false);
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
        Schema::drop('k_matches');
    }
}
