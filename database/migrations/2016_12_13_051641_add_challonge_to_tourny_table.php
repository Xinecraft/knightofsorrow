<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChallongeToTournyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('k_tournaments', function (Blueprint $table) {
            $table->string('challonge_src')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('k_tournaments', function (Blueprint $table) {
            $table->dropColumn('challonge_src');
        });
    }
}
