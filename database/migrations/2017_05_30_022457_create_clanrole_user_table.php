<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClanroleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clanrole_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('clanrole_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('clanrole_id')->references('id')->on('clanroles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'clanrole_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clanrole_user');
    }
}
