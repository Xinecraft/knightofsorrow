<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //DB::table('mails')->truncate();

        Schema::table('mails', function (Blueprint $table) {
            $table->dropColumn('subject');
            $table->renameColumn('body','message');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mails', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->string('subject')->after('reciever_id');
            $table->renameColumn('message','body');
        });
    }
}
