<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pollos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pollq_id')->unsigned();
            $table->foreign('pollq_id')->references('id')->on('pollqs')->onDelete('cascade');
            $table->string('option');
            $table->smallInteger('sort_no')->nullable();
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
        Schema::drop('pollos');
    }
}
