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

Route::get('test',function(){
    dd(App\Mail::conversation(36,32));
});

/**
 * Auth Controllers.
 */
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/**
 * General and Home Controllers.
 */
Route::get('/',['as' => 'home', 'uses' => 'MainController@getIndex']);
Route::get('home',['as' => 'home2', 'uses' => 'MainController@getIndex']);



/**
 * API Controllers
 */
Route::group(['prefix' => 'api'],function(){

    Route::get('server-chats/get',['as' => 'api-server-chats', 'uses' => 'ApiController@getServerChats']);

    Route::get('server-query/get',['as' => 'api-server-query', 'uses' => 'ApiController@getServerQuery']);

    Route::get('users/{query}',['as' => 'api-user-query', 'uses' => 'ApiController@getQueryUser']);

    Route::get('players/{query}',['as' => 'api-players-query', 'uses' => 'ApiController@getQueryPlayer']);

    Route::get('whois',['as' => 'api-server-whois', 'uses' => 'ApiController@whois']);
});


/**
 * Statistics Controllers
 */
Route::group(['prefix' => 'statistics'],function(){
    Route::get('/',['as' => 'statistics-home', 'uses' => 'StatisticsController@getTopPlayers']);
    Route::get('round-reports',['as' => 'round-reports', 'uses' => 'StatisticsController@getRoundReports']);
    Route::get('top-players',['as' => 'top-players', 'uses' => 'StatisticsController@getTopPlayers']);
    Route::get('countries',['as' => 'countries-list', 'uses' => 'StatisticsController@getAllCountries']);
    Route::get('country/{id}/{name}/players',['as' => 'country-detail', 'uses' => 'StatisticsController@getCountryDetails']);
    Route::get('charts',['as' => 'chart-reports', 'uses' => 'StatisticsController@getChartReports']);
    Route::get('player/{id?}/{name}/',['as' => 'player-detail', 'uses' => 'StatisticsController@getPlayerDetails']);
    Route::get('round-reports/detail/{id}',['as' => 'round-detail', 'uses' => 'StatisticsController@getRoundDetails']);

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

/*
 * Removed because new messaging system has be developed!
 *
Route::group(['prefix' => 'mail'],function(){
    Route::get('inbox',['middleware' => 'auth', 'as' => 'user.inbox', 'uses' => 'UserController@getInbox']);
    Route::get('outbox',['middleware' => 'auth', 'as' => 'user.outbox', 'uses' => 'UserController@getOutbox']);
    Route::get('compose',['middleware' => 'auth', 'as' => 'user.compose', 'uses' => 'UserController@getComposeMail']);
    Route::post('compose',['middleware' => 'auth', 'as' => 'user.compose.post', 'uses' => 'UserController@postComposeMail']);
    Route::get('{id}',['middleware' => 'auth', 'as' => 'user.inbox.show', 'uses' => 'UserController@getShowMail']);
});
*/

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
Route::delete('/shouts/{id}/delete', ['as' => 'shouts.delete', 'uses' => 'ShoutsController@destroy']);

// For Ingame Chatting
Route::post('/server/chat',['as' => 'server.chat', 'uses' => 'ServerController@chatInGameForKOS']);

// Rules Page
Route::get('/rules', ['as' => 'rules', 'uses' => 'MainController@getRulesOfServer']);

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
 * Server Chat View Log for Admins
 */
Route::get('/chat-history', ['as' => 'chat.index', 'uses' => 'ChatController@index']);

/**
 * Messages/Mail Controller
 */
Route::get('/conversation/new', ['as' => 'messages.new', 'uses' => 'MailController@start']);
Route::get('/messages/@{username}', ['as' => 'messages.show', 'uses' => 'MailController@show']);
Route::post('/messages/@{username}', ['as' => 'messages.store', 'uses' => 'MailController@store']);
Route::get('/administrator/messages/@{username1}/@{username2}', ['middleware' => 'admin', 'as' => 'messages.showadmin', 'uses' => 'MailController@showadmin']);
Route::delete('/messages/{id}', ['as' => 'messages.delete', 'uses' => 'MailController@destroy']);
Route::get('messages/',['as' => 'messages.index', 'uses' => 'MailController@index']);