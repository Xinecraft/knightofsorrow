<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGrAndMoreToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gr_id')->nullable();
            $table->string('evolve_id')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('website_url')->nullable();
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
            $table->dropColumn('gr_id');
            $table->dropColumn('evolve_id');
            $table->dropColumn('facebook_url');
            $table->dropColumn('website_url');
        });
    }
}
