<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ip_address');
            $table->string('location')->nullable();
            $table->timestamp('ban_time')->nullable();
            $table->integer('server_id')->unsigned();
            $table->integer('country_id')->unsigned()->nullable();
            //$table->foreign('server_id')->refrences('id')->on('servers');
            $table->string('reason')->nullable();
            $table->string('admin_name');
            $table->string('admin_ip');
            $table->boolean('status');
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
        Schema::drop('bans');
    }
}
