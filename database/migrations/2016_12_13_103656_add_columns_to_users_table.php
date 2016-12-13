<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('back_img_url')->nullable();
            $table->integer('koin')->default(0);
            $table->string('discord_username')->nullable();
            $table->boolean('email_notifications_new_message')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('back_img_url');
            $table->dropColumn('koin');
            $table->dropColumn('discord_username');
            $table->dropColumn('email_notifications_new_message');
        });
    }
}
