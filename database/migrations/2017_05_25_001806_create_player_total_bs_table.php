<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerTotalBsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_total_bs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('alias_id')->unsigned();
            $table->integer('profile_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->boolean('is_admin')->default(0);
            $table->integer('total_score')->default(0);
            $table->integer('highest_score')->default(0);
            $table->integer('total_time_played')->default(0);
            $table->integer('total_kills')->default(0);
            $table->integer('total_team_kills')->default(0);
            $table->integer('total_deaths')->default(0);
            $table->integer('total_suicides')->default(0);
            $table->integer('total_arrests')->default(0);
            $table->integer('total_arrested')->default(0);
            $table->integer('best_killstreak')->default(0);
            $table->integer('best_deathstreak')->default(0);
            $table->integer('best_arreststreak')->default(0);
            $table->integer('total_points')->default(0);
            $table->integer('total_round_played')->default(0);
            $table->integer('rank_id')->nullable()->unsigned();
            $table->integer('position')->nullable();
            $table->integer('last_loadout_id')->nullable()->unsigned();
            $table->smallInteger('last_team')->default(0);
            $table->integer('first_game_id')->unsigned();
            $table->integer('last_game_id')->unsigned();
            $table->float('game_win_percentage')->default(0);
            $table->float('game_lost_percentage')->default(0);
            $table->float('game_draw_percentage')->default(0);
            $table->float('killdeath_ratio')->default(0);
            $table->float('arr_ratio')->default(0);
            $table->float('score_percentile')->default(0);
            $table->float('rating')->default(0);
            $table->string('last_ip_address');
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
        Schema::drop('player_total_bs');
    }
}
