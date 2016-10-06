<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrophiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trophies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('photo_id')->unsigned()->nullable();
            $table->string('icon')->nullable();                 // For font awsome
            $table->string('color')->nullable();                 // For font color
            $table->integer('koins')->nullable();               // Koins awarded
            $table->integer('max_bearer')->nullable();          // Max no of user can hold this.
            $table->integer('user_id')->unsigned();             // Creator User ID
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
        Schema::drop('trophies');
    }
}
