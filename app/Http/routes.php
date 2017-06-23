<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Event::listen('router.before',function(){
    Session::put('query_no',0);
});
Event::listen('illuminate.query', function($query){
    $q = Session::get('query_no');
    ++$q;
    Session::put('query_no',$q);
});

/**
 * Auth Controllers.
 */
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::any('/confirmtion/user/{user}/{confirmation_token}',['as' => 'user.email.confirmation', 'uses' => 'UserController@confirmEmail']);
Route::any('/resend-email-confirmation',['middleware' => 'auth', 'as' => 'user.email.confirmation.resend', 'uses' => 'UserController@resendConfirmEmail']);

/**
 * General and Home Controllers.
 */
Route::get('/',['as' => 'home', 'uses' => 'MainController@getIndex']);
Route::get('home',['as' => 'home2', 'uses' => 'MainController@getIndex']);
Route::get('redirects',['as' => 'redirector', 'uses' => 'MainController@redirects']);



/**
 * API Controllers
 */
Route::group(['prefix' => 'api'],function(){

    Route::get('server-chats/get',['as' => 'api-server-chats', 'uses' => 'ApiController@getServerChats']);

    Route::get('server-query/get',['as' => 'api-server-query', 'uses' => 'ApiController@getServerQueryv2']);
    Route::get('server-query/get3',['as' => 'api-server-query', 'uses' => 'ApiController@getServerQueryv3']);

    Route::get('users/{query}',['as' => 'api-user-query', 'uses' => 'ApiController@getQueryUser']);
    Route::get('users2/{query}',['as' => 'api-user-query2', 'uses' => 'ApiController@getQueryUser2']);

    Route::get('players/{query}',['as' => 'api-players-query', 'uses' => 'ApiController@getQueryPlayer']);

    Route::get('whois',['as' => 'api-server-whois', 'uses' => 'ApiController@whois']);

    Route::get('whoisforserver',['as' => 'api-server-whoisforserver', 'uses' => 'ApiController@whoisforserver']);

    Route::get('ip2cc/{IP}', ['as' => 'api-ip-country', 'uses' => 'ApiController@getCountryCodeFromIP']);
    Route::get('whois-ip/{IP}', ['as' => 'api.ip.country', 'uses' => 'ApiController@getCountryFromIP']);

    Route::any('translate', ['as' => 'api-translate', 'uses' => 'ApiController@translateText']);

    Route::get('joke', ['as' => 'api-joke', 'uses' => 'ApiController@getRandomJoke']);
    Route::get('insult', ['as' => 'api-insult', 'uses' => 'ApiController@getRandomInsult']);
    Route::get('swathint', ['as' => 'api-hint', 'uses' => 'ApiController@getRandomSwathint']);
    Route::get('nsfw-boobs', ['as' => 'api-bo', 'uses' => 'ApiController@getRandomBoobs']);
    Route::get('nsfw-ass', ['as' => 'api-as', 'uses' => 'ApiController@getRandomAss']);
    Route::get('nsfw-meme', ['as' => 'api-meme', 'uses' => 'ApiController@getRandomMeme']);
    Route::get('nsfw-gif', ['as' => 'api-gif', 'uses' => 'ApiController@getRandomGif']);
});


/**
 * Statistics Controllers
 */
Route::group(['prefix' => 'statistics'],function(){
    Route::get('/',['as' => 'statistics-home', 'uses' => 'StatisticsController@getTopPlayers']);
    Route::get('round-reports',['as' => 'round-reports', 'uses' => 'StatisticsController@getRoundReports']);
    Route::get('war-round-reports',['as' => 'war-round-reports', 'uses' => 'StatisticsController@getWarRoundReports']);
    Route::get('top-players',['as' => 'top-players', 'uses' => 'StatisticsController@getTopPlayers']);
    Route::get('countries',['as' => 'countries-list', 'uses' => 'StatisticsController@getAllCountries']);
    Route::get('country/{id}/{name}/players',['as' => 'country-detail', 'uses' => 'StatisticsController@getCountryDetails']);
    Route::get('charts',['as' => 'chart-reports', 'uses' => 'StatisticsController@getChartReports']);
    Route::get('player/{name}/',['as' => 'player-detail', 'uses' => 'StatisticsController@getPlayerDetails']);
    Route::get('player/{name}/rounds',['as' => 'player-rounds', 'uses' => 'StatisticsController@getPlayerRounds']);
    Route::get('player/{name}/delete',['as' => 'player-delete', 'uses' => 'StatisticsController@getPlayerDelete']);
    Route::post('player/{name}/delete',['as' => 'player-delete-post', 'uses' => 'StatisticsController@postPlayerDelete']);
    Route::post('player/{name}/undelete',['as' => 'undelete-player', 'uses' => 'StatisticsController@postPlayerUndelete']);

    Route::get('round-reports/detail/{id}',['as' => 'round-detail', 'uses' => 'StatisticsController@getRoundDetails']);
    Route::get('war-round-reports/detail/{id}',['as' => 'war-round-detail', 'uses' => 'StatisticsController@getRoundDetails']);

    Route::get('top-10',['as' => 'top10', 'uses' => 'StatisticsController@getTop10']);

    Route::get('ajax/round-player/{id}',['as' => 'ajax-round-player', 'uses' => 'StatisticsController@getRoundPlayerWithAjax']);
});


/**
 * Status Updates Controllers
 */
Route::get('/feeds',['middleware' => 'auth', 'as' => 'feeds-home', 'uses' => 'StatusController@index']);
Route::post('/feeds',['middleware' => 'auth', 'as' => 'post-status', 'uses' => 'StatusController@store']);
Route::get('/feeds/{id}/',['as' => 'show-status', 'uses' => 'StatusController@show']);
Route::get('/feeds/{id}/edit',['middleware' => 'auth', 'as' => 'edit-status', 'uses' => 'StatusController@edit']);
Route::put('/feeds',['middleware' => 'auth', 'as' => 'put-status', 'uses' => 'StatusController@update']);
Route::delete('/feeds',['middleware' => 'auth', 'as' => 'delete-status', 'uses' => 'StatusController@destroy']);

/**
 * User and Follow System Controllers
 */
Route::get('@{username}',['as' => 'user.show', 'uses' => 'UserController@showProfile']);
Route::get('profile',['middleware' => 'auth', 'as' => 'user.profile', 'uses' => 'UserController@showOwnProfile']);
Route::get('profile/edit',['middleware' => 'auth','as' => 'user.setting', 'uses' => 'UserController@editOwnProfile']);
Route::post('profile/edit',['middleware' => 'auth','as' => 'user.setting.post', 'uses' => 'UserController@updateProfile']);
Route::post('follow',['middleware' => 'auth', 'as' => 'follow-user', 'uses' => 'UserController@postFollow']);
Route::delete('follow',['middleware' => 'auth', 'as' => 'unfollow-user', 'uses' => 'UserController@deleteUnfollow']);
Route::post('feeds/{id}/comments',['middleware' => 'auth', 'as' => 'status-comment', 'uses' => 'CommentController@storeForStatus']);
Route::get('/user/ping',['as' => 'user.ping', 'uses' => 'UserController@sendPing']);
Route::post('profile/edit2', ['middleware' => 'auth', 'as' => 'user.setting2.post', 'uses' => 'UserController@updateProfile2']);
Route::patch('/toggleban/@{username}',['middleware' => 'auth', 'as' => 'user.toggleban', 'uses' => 'UserController@toggleBanUser']);
Route::patch('/togglemute/@{username}',['middleware' => 'auth', 'as' => 'user.togglemute', 'uses' => 'UserController@toggleMuteUser']);
Route::post('/changerole/@{username}',['middleware' => ['auth','admin'], 'as' => 'user.changerole', 'uses' => 'UserController@changeRole']);
Route::get('/viewserverkeys',['middleware' => 'auth','as' => 'user.viewkeys', 'uses' => 'UserController@viewServerCredentials']);
Route::post('/viewserverkeys',['middleware' => 'auth','as' => 'user.viewkeys.post', 'uses' => 'UserController@postServerCredentials']);
Route::get('/admins-list',['as' => 'admin.list', 'uses' => 'UserController@adminList']);
Route::get('/webadmin',['as' => 'webadmin', 'middleware' => ['auth','admin'], 'uses' => 'UserController@getWebAdmin']);

/**
 * Servers Controllers.
 * This is listing of all servers Servers of SWAT4.
 */
Route::group(['prefix' => 'servers'],function(){
    Route::get('',['as' => 'servers.list', 'uses' => 'ServerController@index']);
    Route::get('new',['middleware' => 'admin', 'as' => 'servers.new', 'uses' => 'ServerController@create']);
    Route::post('new',['middleware' => 'admin', 'as' => 'servers.new.post', 'uses' => 'ServerController@store']);
    Route::get('{id}',['as' => 'servers.show', 'uses' => 'ServerController@show']);
});

/**
 * Server Trackers group to respond when a HTTP request arrives from SWAT4 Server.
 */
Route::group(['prefix' => 'servertracker'], function(){
    /**
     * Server round end Controller
     *
     * This route will handle the posting and storage of all data coming from
     * server to the website as a POST request
     */
    Route::post('rounds/{key}/',['as' => 'server-tracker', function($key){
        if($key != env('SERVER_QUERY_KEY')) {
            Log::error("Error! Server key invalid. Can't save round record to Database.");
        }
        else {
            $game = new App\Server\ServerTracker($_POST);
            $game->track();
        }
    }]);

    /**
     * WAR SERVER TRACKER FOR WARS AND TOURNAMENTS
     */
    Route::post('wars/{key}/',['as' => 'server-tracker', function($key){
        if($key != env('SERVER_QUERY_KEY')) {
            Log::error("Error! Server key invalid. Can't save round record to Database.");
        }
        else {
            $game = new App\Server\WarServerTracker($_POST);
            $game->track();
        }
    }]);

    /**
     * Server Chat messages Controller
     *
     * This route will handle the posting and storage of all chats from server
     * to the website db as a GET request
     */
    Route::post('chats/{key}/',['as' => 'chat-tracker',function($key){
        if($key != env('SERVER_QUERY_KEY')) {
            Log::error("Error! Server key invalid. Can't save chat record to Database.");
        }
        else {
            $chat = new App\Server\ChatTracker($_POST);
            $chat->track();
        }
    }]);
});

/**
 * Shouts Controller
 */
Route::post('/shouts/do',['as' => 'shouts.store', 'uses' => 'ShoutsController@store']);
Route::get('/getShouts',['as' => 'shouts.get', 'uses' => 'ShoutsController@getShouts']);
Route::delete('/shouts/{id}/delete', ['as' => 'shouts.delete', 'uses' => 'ShoutsController@destroy']);

// For In game Chatting
Route::post('/server/chat',['middleware' => 'auth', 'as' => 'server.chat', 'uses' => 'ServerController@chatInGameForKOS']);

// Rules Page
Route::get('/rules', ['as' => 'rules', 'uses' => 'MainController@getRulesOfServer']);
Route::get('/rules-of-usclan', ['as' => 'us.rules', 'uses' => 'MainController@getRulesOfClan']);

/**
 * News Controller
 */
Route::get('/news', ['as' => 'news.index', 'uses' => 'NewsController@index']);
Route::get('/news/new', ['middleware' => 'admin', 'as' => 'news.create', 'uses' => 'NewsController@create']);
Route::post('/news/new', ['middleware' => 'admin', 'as' => 'news.store', 'uses' => 'NewsController@store']);
Route::get('/news/{slug}', ['as' => 'news.show', 'uses' => 'NewsController@show']);
Route::get('/news/{id}/edit', ['middleware' => 'admin', 'as' => 'news.edit', 'uses' => 'NewsController@edit']);
Route::post('/news/{id}/edit', ['middleware' => 'admin', 'as' => 'news.update', 'uses' => 'NewsController@update']);

/**
 * Poll Controller
 */
Route::get('polls/new',['middleware' => 'admin', 'as' => 'poll.create', 'uses' => 'PollController@create']);
Route::post('polls/new',['middleware' => 'admin', 'as' => 'poll.store', 'uses' => 'PollController@store']);
Route::get('polls',[ 'as' => 'poll.index', 'uses' => 'PollController@index']);
Route::post('polls/{id}/vote',['middleware' => 'auth', 'as' => 'poll.vote', 'uses' => 'PollController@vote']);

/**
 * Server Chat View Log for Admins
 */
Route::get('/serverchat-history', ['as' => 'chat.index', 'uses' => 'ChatController@index']);

/**
 * Messages/Mail Controller
 */
Route::get('/conversation/new', ['as' => 'messages.new', 'uses' => 'MailController@start']);
Route::get('/messages/@{username}', ['as' => 'messages.show', 'uses' => 'MailController@show']);
Route::post('/messages/@{username}', ['as' => 'messages.store', 'uses' => 'MailController@store']);
Route::get('/administrator/messages/@{username1}/@{username2}', ['middleware' => 'admin', 'as' => 'messages.showadmin', 'uses' => 'MailController@showadmin']);
Route::delete('/messages/{id}', ['as' => 'messages.delete', 'uses' => 'MailController@destroy']);
Route::get('messages/',['as' => 'messages.index', 'uses' => 'MailController@index']);

Route::get('downloads',['as' => 'download', 'uses' => 'DownloadController@index']);
Route::get('/downloads/{name}', ['as' => 'downloads', 'uses' => 'DownloadController@download']);

/**
 * Bans Controller
 */

Route::group(['middleware' => ['auth','admin']],function(){
    Route::get('/banlist/create',['as' => 'bans.create', 'uses' => 'BanController@create']);
    Route::post('/banlist/create',['as' => 'bans.store', 'uses' => 'BanController@store']);
    Route::get('/banlist/{id}/edit',['as' => 'bans.edit', 'uses' => 'BanController@edit']);
    Route::post('/banlist/{id}/edit',['as' => 'bans.update', 'uses' => 'BanController@update']);
});
Route::post('/servertracker/handlebans/', ['as' => 'bans.handleban', 'uses' => 'BanController@handlebans']);
Route::get('/banlist',['as' => 'bans.index', 'uses' => 'BanController@index']);
Route::get('/banlist/{id}',['as' => 'bans.show', 'uses' => 'BanController@show']);
Route::post('banlist/{id}/comments',['middleware' => 'auth', 'as' => 'ban-comment', 'uses' => 'CommentController@storeForBan']);

/**
 * Master ban List in txt
 */
Route::get('/download/adminmoddata/masterbanlist.txt',['as' => 'bans.txt', 'uses' => 'BanController@masterbantxt']);

Route::post('/kosadmin',['middleware' => ['auth', 'admin'],'as' => 'kosadmin.commands', 'uses' => 'ServerController@adminCommand']);
Route::post('/kossrvadmin',['middleware' => ['auth', 'admin'],'as' => 'kossrvadmin.commands', 'uses' => 'ServerController@adminCommand']);
Route::get('liveplayeraction',['middleware' => ['auth','admin'], 'as' => 'liveplayeraction', 'uses' => 'ServerController@liveplayeraction']);
Route::get('liveserveraction',['middleware' => ['auth','admin'], 'as' => 'liveserveraction', 'uses' => 'ServerController@liveserveraction']);

Route::post('/kost', ['as' => 'kost', 'uses' => 'KostController@kost']);

/**
 * Tournament System Controllers
 */
Route::get('/tournament/livestream', ['as' => 'tournament.stream', 'uses' => 'MainController@stream']);
Route::get('/tournament/calendar', [ 'as' => 'tournament.calendar', 'uses' => 'TournamentController@getCalendar']);
Route::get('/tournament/ranking/single', [ 'as' => 'tournament.ranking.single', 'uses' => 'TournamentController@getRatingSingle']);
Route::get('/tournament/ranking/teams', [ 'as' => 'tournament.ranking.teams', 'uses' => 'TournamentController@getRatingTeams']);
Route::get('/tournament/guidelines', [ 'as' => 'tournament.guidelines', 'uses' => 'TournamentController@getGuideline']);
Route::get('/tournament/worldclock', [ 'as' => 'tournament.wc', 'uses' => 'TournamentController@getWorldClock']);
Route::get('/tournament/create', ['middleware' => ['auth','admin'], 'as' => 'tournament.create', 'uses' => 'TournamentController@create']);
Route::post('/tournament/create', ['middleware' => ['auth','admin'], 'as' => 'tournament.store', 'uses' => 'TournamentController@store']);
Route::get('/tournament/{slug}', ['as' => 'tournament.show', 'uses' => 'TournamentController@show']);
Route::get('/tournament/{slug}/bracket', ['as' => 'tournament.bracket.show', 'uses' => 'TournamentController@getBracket']);
Route::get('/tournament/{slug}/apply', ['middleware' => 'auth', 'as' => 'tournament.apply', 'uses' => 'TournamentController@applyForUser']);
Route::post('/tournament/{id}/apply/new', ['middleware' => 'auth', 'as' => 'tournament.apply.new', 'uses' => 'TournamentController@applyForUserNewTeam']);
Route::post('/tournament/{id}/apply/existing', ['middleware' => 'auth', 'as' => 'tournament.apply.existing', 'uses' => 'TournamentController@applyForUserExistingTeam']);
Route::get('/tournament/{id}/leave', ['middleware' => 'auth', 'as' => 'tournament.leave', 'uses' => 'TournamentController@leaveTournamentForUser']);
Route::get('/tournament/{slug}/team/{id}', [ 'as' => 'tournament.team.show', 'uses' => 'TournamentController@showTeam']);
Route::post('/tournament/{slug}/team/{id}/user/{userid}/approve', ['middleware' => 'auth', 'as' => 'tournament.team.player.approve', 'uses' => 'TournamentController@approvePlayerToTeam']);
Route::post('/tournament/{slug}/team/{id}/user/{userid}/pending', ['middleware' => 'auth', 'as' => 'tournament.team.player.pending', 'uses' => 'TournamentController@pendingPlayerToTeam']);
Route::delete('/tournament/{slug}/team/{id}/user/{userid}/reject', ['middleware' => 'auth', 'as' => 'tournament.team.player.reject', 'uses' => 'TournamentController@rejectPlayerToTeam']);
Route::post('/tournament/{slug}/team/{id}/close', ['middleware' => 'auth', 'as' => 'tournament.team.makeclose', 'uses' => 'TournamentController@closeTeamForJoining']);
Route::post('/tournament/{slug}/team/{id}/open', ['middleware' => 'auth', 'as' => 'tournament.team.makeopen', 'uses' => 'TournamentController@openTeamForJoining']);
Route::post('/tournament/{slug}/team/{id}/handleteams', ['middleware' => 'auth', 'as' => 'tournament.team.handleteams', 'uses' => 'TournamentController@handleTeamsForManager']);
Route::get('/tournament', [ 'as' => 'tournament.index', 'uses' => 'TournamentController@index']);
Route::get('/tournament/{slug}/match/{id}/', [ 'as' => 'tournament.match.show', 'uses' => 'TournamentController@getTournamentMatch']);
Route::post('/tournament/{slug}/match/{id}/', [ 'as' => 'tournament.match.show.post', 'uses' => 'TManagerController@postUploadShots']);

Route::get('/tournament/{slug}/match/{id}/calculate', ['middleware' => 'auth', 'as' => 'tournament.match.getcalculate', 'uses' => 'TManagerController@getCalculateMatch']);
Route::any('/tournament/{slug}/match/{id}/calculatex', ['middleware' => 'auth', 'as' => 'tournament.match.postcalculate', 'uses' => 'TManagerController@postCalculateMatch']);
Route::post('/tournament/{slug}/match/{id}/calculatefinal', ['middleware' => 'auth', 'as' => 'tournament.match.postcalculatefinal', 'uses' => 'TManagerController@postCalculateMatchFinal']);

Route::post('tournament/{id}/comments',['middleware' => 'auth', 'as' => 'tournament.comment', 'uses' => 'CommentController@storeForTournament']);

Route::get('/tournament/{slug}/end',['middleware' => 'auth', 'as' => 'tournament.end', 'uses' => 'TManagerController@shoeEndPage']);

Route::get('global-notifications',['as' => 'notifications.index', 'uses' => 'NotificationController@indexGlobal']);
Route::get('notifications',['middleware' => 'auth', 'as' => 'notifications.userindex', 'uses' => 'NotificationController@indexUser']);
Route::get('getlatestnotifications',['middleware' => 'auth', 'as' => 'notifications.getlatest', 'uses' => 'NotificationController@getLatest']);

Route::get('/image/{url}/thumbnail/{width?}', ['as' => 'make.thumbnail', 'uses' => 'PhotosController@thumbnail']);

Route::delete('/comment/{id}',['as' => 'comment.destroy', 'uses' => 'CommentController@destroy']);

Route::get('/viewiphistory',['middleware' => ['auth','admin'], 'uses' => 'StatisticsController@viewIPofPlayer']);
Route::get('/viewiphistoryuser',['middleware' => ['auth','admin'], 'uses' => 'UserController@viewIPofUser']);

Route::get('deleted-players',['as' => 'deleted-players', 'uses' => 'StatisticsController@getDeletedPlayersForView']);

// Points to players
Route::get('/statistics/awardedpoints/create',['as' => 'addpoints.create', 'middleware' => ['auth','admin'], 'uses' => 'AdminController@createAddpoints']);
Route::post('/statistics/awardedpoints/create',['middleware' => ['auth','admin'], 'uses' => 'AdminController@storeAddpoints']);
Route::post('/statistics/awardedpoints/delete/{id}',['as' => 'delete-playerpoints','middleware' => ['auth','admin'], 'uses' => 'AdminController@destroyAddpoints']);

Route::get('/statistics/awardedpoints',['as' => 'extrapoints', 'uses' => 'StatisticsController@showExtrapoints']);

//Trophy System
Route::get('/trophy/create',['middleware' => ['auth','admin'], 'as' => 'trophy.create', 'uses' => 'TrophyController@create']);
Route::post('/trophy/create',['middleware' => ['auth','admin'], 'as' => 'trophy.store', 'uses' => 'TrophyController@store']);
Route::get('/trophy/give_to_user',['middleware' => ['auth','admin'], 'as' => 'trophy.grant', 'uses' => 'TrophyController@giveToUser']);
Route::post('/trophy/give_to_user',['middleware' => ['auth','admin'], 'as' => 'trophy.postgrant', 'uses' => 'TrophyController@postGiveToUser']);

//Route::get('/stream', ['uses' => 'MainController@stream']);

Route::get('/ssh',['as' =>'restartserver',function(){

    if(Auth::check() && Auth::user()->isAdmin()) {
        $commands = array(
            'cd SWAT4/Content',
            'cp SwatGame.ini System/',
            'cd System',
            'sh server.sh'
        );
        SSH::run($commands, function ($line) {
            //dd($line.PHP_EOL);
        });

        return redirect()->home()->with('message','Success! Server is restarting now');
    }
    else
    {
        abort(404);
    }

}]);

Route::get('/us-members',['as' => 'us.members', 'uses' => 'MainController@getuSmembers']);
Route::get('/searchip',['middleware' => 'auth','as' => 'user.searchip', 'uses' => 'UserController@getSearchIP']);
Route::post('/searchip',['middleware' => 'auth','as' => 'user.searchip.post', 'uses' => 'UserController@postSearchIP']);

Route::get('/copy', function(){
    DB::table('player_totals')->truncate();
    $ramdomTableName = "/var/lib/mysql-files/".'table'.str_random(10).".txt";
    $query = "SELECT * INTO OUTFILE '$ramdomTableName' FROM player_total_bs;LOAD DATA INFILE '$ramdomTableName' INTO TABLE player_totals;";
    DB::connection()->getpdo()->exec($query);
});


/**
 * Firewall Controller
 */
Route::get('/admin/firewall', ['middleware' => ['auth', 'admin'], 'as' => 'firewall.index', 'uses' => 'FirewallController@index']);
Route::post('/admin/firewall', ['middleware' => ['auth', 'admin'], 'as' => 'firewall.store', 'uses' => 'FirewallController@store']);
Route::delete('/admin/firewall/{ip}', ['middleware' => ['auth', 'admin'], 'as' => 'firewall.destroy', 'uses' => 'FirewallController@destroy']);


/**
 * TinyURL
 */
Route::get('/discord',function(){
    return Redirect::to("https://discord.gg/Y8DzuUU");
});
Route::get('/Swat4eveR',function(){
    return Redirect::to("https://discordapp.com/oauth2/authorize?&client_id=321798131354304515&scope=bot&permissions=470019135");
});