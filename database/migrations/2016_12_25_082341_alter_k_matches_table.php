<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterKMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('k_matches', function (Blueprint $table) {
            $table->text('game1_screenshot')->nullable();
            $table->text('game2_screenshot')->nullable();
            $table->text('game3_screenshot')->nullable();
            $table->text('game4_screenshot')->nullable();
            $table->text('game5_screenshot')->nullable();
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
            $table->dropColumn('game1_screenshot');
            $table->dropColumn('game2_screenshot');
            $table->dropColumn('game3_screenshot');
            $table->dropColumn('game4_screenshot');
            $table->dropColumn('game5_screenshot');
        });
    }
}
