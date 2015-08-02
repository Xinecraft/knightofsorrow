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
    dd(App\User::lists('id'));
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
Route::post('follow',['middleware' => 'auth', 'as' => 'follow-user', 'uses' => 'UserController@postFollow']);
Route::delete('follow',['middleware' => 'auth', 'as' => 'unfollow-user', 'uses' => 'UserController@deleteUnfollow']);

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
    Route::get('chats/{key}/',['as' => 'chat-tracker',function($key){
        if($key != env('SERVER_QUERY_KEY')) {
            Log::error("Error! Server key invalid. Can't save chat record to Database.");
        }
        else {
            $chat = new App\Server\ChatTracker($_GET);
            $chat->track();
        }
    }]);
});