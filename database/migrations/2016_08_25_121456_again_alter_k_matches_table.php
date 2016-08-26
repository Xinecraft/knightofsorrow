<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgainAlterKMatchesTable extends Migration
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
             * FOR ELIMINATIONS ONLY
             */
            $table->integer('match_index')->nullable()->after('k_round_id');
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
            $table->dropColumn('match_index');
        });
    }
}
