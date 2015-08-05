<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlayerTotalNameAndRemovePlayerTotalIdFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('player_totals_name')->nullable()->unique()->index()->default(null)->after('confirmation_token');
            $table->dropForeign('users_playertotal_id_foreign');
            $table->dropColumn('playertotal_id');
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
            $table->dropColumn('player_totals_name')->after('confirmation_token');
            $table->integer('playertotal_id')->unsigned()->nullable()->default(null);
            $table->foreign('playertotal_id')->references('id')->on('player_totals');
        });
    }
}
