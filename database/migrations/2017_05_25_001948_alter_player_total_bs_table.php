<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPlayerTotalBsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('player_total_bs', function (Blueprint $table) {
            $table->dropColumn('game_win_percentage');
            $table->dropColumn('game_lost_percentage');
            $table->dropColumn('game_draw_percentage');
            $table->dropColumn('rating');
            $table->integer('game_draw')->default(0)->after('last_game_id');
            $table->integer('game_lost')->default(0)->after('last_game_id');
            $table->integer('game_won')->default(0)->after('last_game_id');
            $table->float('player_rating')->default(null)->nullable()->after('score_percentile');
            $table->float('score_per_min')->nullable()->after('score_percentile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player_total_bs', function (Blueprint $table) {
            $table->dropColumn('game_draw');
            $table->dropColumn('game_lost');
            $table->dropColumn('game_won');
            $table->dropColumn('player_rating');
            $table->dropColumn('score_per_min');
            $table->float('game_win_percentage')->default(0)->after('last_game_id');
            $table->float('game_lost_percentage')->default(0)->after('game_win_percentage');
            $table->float('game_draw_percentage')->default(0)->after('game_lost_percentage');
            $table->float('rating')->default(0)->after('score_percentile');
        });
    }
}
