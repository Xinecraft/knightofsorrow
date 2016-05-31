<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeyContraintsToAllTables extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('users', function (Blueprint $table) {
			$table->foreign('playertotal_id')->references('id')->on('player_totals');
			/*$table->foreign('country_id')->references('id')->on('countries');*/
		});

		Schema::table('aliases', function (Blueprint $table) {
			$table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
		});

		Schema::table('clans', function (Blueprint $table) {
			$table->foreign('server_id')->references('id')->on('servers');
			$table->foreign('approved_by')->references('id')->on('users');
			$table->foreign('submitter_id')->references('id')->on('users');
		});

		Schema::table('news', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
		});

		Schema::table('players', function (Blueprint $table) {
			/*$table->foreign('country_id')->references('id')->on('countries');*/
			$table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
			$table->foreign('alias_id')->references('id')->on('aliases');
			$table->foreign('loadout_id')->references('id')->on('loadouts');
		});

		Schema::table('profiles', function (Blueprint $table) {
			/*$table->foreign('country_id')->references('id')->on('countries');*/
			$table->foreign('loadout_id')->references('id')->on('loadouts');
			$table->foreign('game_first')->references('id')->on('games');
			$table->foreign('game_last')->references('id')->on('games');
		});

		Schema::table('servers', function (Blueprint $table) {
			/*$table->foreign('country_id')->references('id')->on('countries');*/
			$table->foreign('submitter_id')->references('id')->on('users');
		});

		Schema::table('weapons', function (Blueprint $table) {
			$table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
		});

		Schema::table('player_totals', function (Blueprint $table) {
			$table->foreign('alias_id')->references('id')->on('aliases');
			$table->foreign('profile_id')->references('id')->on('profiles');
			/* $table->foreign('country_id')->references('id')->on('countries');*/
			$table->foreign('rank_id')->references('id')->on('ranks');
			$table->foreign('last_loadout_id')->references('id')->on('loadouts');
			$table->foreign('first_game_id')->references('id')->on('games');
			$table->foreign('last_game_id')->references('id')->on('games');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function (Blueprint $table) {
			$table->dropForeign('users_playertotal_id_foreign');
			$table->dropForeign('users_country_id_foreign');
		});

		Schema::table('aliases', function (Blueprint $table) {
			$table->dropForeign('aliases_profile_id_foreign');
		});

		Schema::table('clans', function (Blueprint $table) {
			$table->dropForeign('clans_server_id_foreign');
			$table->dropForeign('clans_approved_by_foreign');
			$table->dropForeign('clans_submitter_id_foreign');
		});

		Schema::table('news', function (Blueprint $table) {
			$table->dropForeign('news_user_id_foreign');
		});

		Schema::table('players', function (Blueprint $table) {
			$table->dropForeign('players_game_id_foreign');
			$table->dropForeign('players_alias_id_foreign');
			$table->dropForeign('players_loadout_id_foreign');
		});

		Schema::table('profiles', function (Blueprint $table) {
			$table->dropForeign('profiles_country_id_foreign');
			$table->dropForeign('profiles_loadout_id_foreign');
			$table->dropForeign('profiles_game_first_foreign');
			$table->dropForeign('profiles_game_last_foreign');
		});

		Schema::table('servers', function (Blueprint $table) {
			$table->dropForeign('servers_country_id_foreign');
			$table->dropForeign('servers_submitter_id_foreign');
		});

		Schema::table('weapons', function (Blueprint $table) {
			$table->dropForeign('weapons_player_id_foreign');
		});

		Schema::table('player_totals', function (Blueprint $table) {
			$table->dropForeign('player_totals_alias_id_foreign');
			$table->dropForeign('player_totals_profile_id_foreign');
			$table->dropForeign('player_totals_country_id_foreign');
			$table->dropForeign('player_totals_rank_id_foreign');
			$table->dropForeign('player_totals_last_loadout_id_foreign');
			$table->dropForeign('player_totals_first_game_id_foreign');
			$table->dropForeign('player_totals_last_game_id_foreign');
		});
	}
}
