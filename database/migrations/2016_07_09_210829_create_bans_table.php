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
            //$table->string('location')->nullable();
            $table->timestamp('banned_till')->nullable();
            $table->integer('server_id')->unsigned()->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            //$table->foreign('server_id')->refrences('id')->on('servers');
            $table->string('reason')->nullable();
            $table->string('admin_name');
            $table->string('admin_ip');
            $table->boolean('status');
            $table->string('updated_by')->nullable();
            $table->boolean('created_by_site')->default(0);
            $table->boolean('updated_by_site')->default(0);
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
