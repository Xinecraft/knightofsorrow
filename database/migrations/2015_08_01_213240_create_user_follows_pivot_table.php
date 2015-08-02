<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFollowsPivotTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_follows', function(Blueprint $table)
    {
      $table->increments('id');
      $table->integer('follower_id')->unsigned();
      $table->integer('followed_id')->unsigned();
      $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('followed_id')->references('id')->on('users')->onDelete('cascade');
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
    Schema::drop('user_follows');
  }

}
