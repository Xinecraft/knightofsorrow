<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kosts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('server_ip');
            $table->string('server_port');
            $table->string('server_uid');
            $table->string('type');
            $table->string('playerone');
            $table->string('playerone_ip')->nullable();
            $table->string('playertwo')->nullable();
            $table->string('playertwo_ip')->nullable();
            $table->string('extra')->nullable();
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
        Schema::drop('kosts');
    }
}
