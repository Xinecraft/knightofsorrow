<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Drop3ColumnsAndAdd3InPlayerTotals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('player_totals', function (Blueprint $table) {
            $table->dropColumn('game_win_percentage');
            $table->dropColumn('game_lost_percentage');
            $table->dropColumn('game_draw_percentage');
            $table->integer('game_draw')->default(0)->after('last_game_id');
            $table->integer('game_lost')->default(0)->after('last_game_id');
            $table->integer('game_won')->default(0)->after('last_game_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player_totals', function (Blueprint $table) {
            $table->dropColumn('game_draw');
            $table->dropColumn('game_lost');
            $table->dropColumn('game_won');
            $table->float('game_win_percentage')->default(0)->after('last_game_id');
            $table->float('game_lost_percentage')->default(0)->after('game_win_percentage');
            $table->float('game_draw_percentage')->default(0)->after('game_lost_percentage');
        });
    }
}
