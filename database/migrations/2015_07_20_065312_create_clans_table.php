<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('tag');
            $table->string('image')->nullable();
            $table->enum('gamename',['SWAT4 1.0','SWAT4 1.1','SWAT4 TSS']);
            $table->enum('gamemode',['BS','VIP','CTF','SAD','FFA','SAG']);
            $table->date('founded_on')->nullable();
            $table->string('leader');
            $table->string('motto');
            $table->string('description')->nullable();
            $table->string('website')->nullable();
            $table->string('shortname');
            $table->integer('server_id')->unsigned()->nullable();
            $table->boolean('approved')->default(false);
            $table->integer('approved_by')->unsigned()->nullable();
            $table->integer('submitter_id')->unsigned();
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
        Schema::drop('clans');
    }
}
