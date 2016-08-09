<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k_rounds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('k_tournament_id');
            $table->integer('round_index');
            $table->integer('no_of_matches')->nullable();
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
        Schema::drop('k_rounds');
    }
}
