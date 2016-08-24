<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('k_matches', function (Blueprint $table) {
            /**
             * ID of match from which to get Team ID.
             */
            $table->integer('team1_from_match_index')->nullable()->unsigned()->after('k_team2_id');
            /**
             * TAKE WINNER OR LOSER INDEX
             * 1 -> Take winner of match
             * 2 -> Take loser of match
             */
            $table->integer('team1_from_match_rank')->nullable()->after('team1_from_match_index');
            /**
             * ID of match from which to get Team ID.
             */
            $table->integer('team2_from_match_index')->nullable()->unsigned()->after('team1_from_match_rank');
            /**
             * TAKE WINNER OR LOSER INDEX
             * 1 -> Take winner of match
             * 2 -> Take loser of match
             */
            $table->integer('team2_from_match_rank')->nullable()->after('team2_from_match_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('k_matches', function (Blueprint $table) {
            $table->removeColumn('team1_from_match_index');
            $table->removeColumn('team1_from_match_rank');
            $table->removeColumn('team2_from_match_index');
            $table->removeColumn('team2_from_match_rank');
        });
    }
}
