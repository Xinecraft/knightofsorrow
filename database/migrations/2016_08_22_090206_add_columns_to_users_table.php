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
            $table->integer('clan_id')->nullable()->unsigned();
            /**
             * 0 -> Applied and Pending
             * 1 -> Accepted
             */
            $table->integer('clan_join_status')->nullable();
            /**
             * 0 -> in Trails
             * 1 -> Recruit
             * 2 -> Member
             * 3 -> Elite Member
             * 4 -> Elder Member
             * 5 -> Admin
             * 6 -> Super Admin
             * 7 -> Co-Leader
             * 8 -> Leader
             */
            $table->integer('clan_rank')->nullable();
            $table->string('steam_nickname')->nullable()->after('website_url');
            $table->boolean('muted')->default(false)->after('banned');
            $table->integer('photo_id')->nullable()->unsigned();
            $table->string('back_color')->nullable();
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
            $table->dropColumn('clan_id');
            $table->dropColumn('clan_join_status');
            $table->dropColumn('clan_rank');
            $table->dropColumn('steam_nickname');
            $table->dropColumn('muted');
            $table->dropColumn('photo_id');
            $table->dropColumn('back_color');
        });
    }
}
