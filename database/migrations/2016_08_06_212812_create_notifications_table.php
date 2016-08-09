<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_id')->unsigned()->nullable();   // Whom sent it
            $table->integer('user_id')->unsigned()->nullable();     // Where it is sent
            $table->string('type', 128)->nullable();
            $table->string('subject', 128)->nullable();
            $table->text('body')->nullable();
            $table->integer('object_id')->unsigned()->nullable();
            $table->string('object_type', 128)->nullable();
            $table->boolean('is_read')->default(false);
            $table->boolean('is_stream')->default(false);
            $table->integer('visibility_level')->default(0);
            $table->dateTime('sent_at')->nullable();
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
        Schema::drop('notifications');
    }
}
