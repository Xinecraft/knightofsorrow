<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password', 60);
            $table->date('dob')->nullable()->default(null);
            $table->enum('gender',['Male','Female','Others'])->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->text('about')->nullable();
            $table->smallInteger('role')->default(0);
            $table->string('last_ipaddress')->default('0.0.0.0');
            $table->boolean('confirmed')->default(false);
            $table->boolean('banned')->default(false);
            $table->string('confirmation_token')->nullable();
            $table->integer('playertotal_id')->unsigned()->nullable()->default(null);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
