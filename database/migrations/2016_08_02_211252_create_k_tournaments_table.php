<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k_tournaments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->longText('rules');
            $table->string('game_name')->default('SWAT4 1.0');
            $table->string('game_type')->default('Barricaded Suspects');
            $table->integer('photo_id')->unsigned()->nullable();
            $table->integer('bracket_type')->default(0);     // 0 -> RR, 2-> Single Elimination , 1-> Double Elimination etc
            $table->integer('tournament_type')->default(0);     // 1-> 1v1 ,0 -> 2v2 etc, 2-> 3v3
            $table->integer('minimum_participants');
            $table->integer('maximum_participants');
            $table->integer('rounds_per_match')->default(3);
            $table->timestamp('registration_starts_at');
            $table->timestamp('registration_ends_at');
            $table->timestamp('tournament_starts_at');
            $table->timestamp('tournament_ends_at')->nullable();
            $table->integer('first_team_id')->nullable();
            $table->integer('second_team_id')->nullable();
            $table->integer('third_team_id')->nullable();
            $table->string('slug')->unique();
            $table->integer('parent_tournament')->unsigned()->nullable();
            $table->longText('past_champions')->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('disabled')->default(false);
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
        Schema::drop('k_tournaments');
    }
}
