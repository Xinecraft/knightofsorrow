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

Route::get('/', function () {
    return view('index');
});



/**
 * Server round end Controller
 *
 * This route will handle the posting and storage of all data coming from
 * server to the website as a POST request
 */
Route::post('/tracker/{key}/',['as' => 'tracker', function($key){
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
Route::get('/chattracker/{key}/',['as' => 'chattracker',function($key){
    if($key != env('SERVER_QUERY_KEY')) {
        Log::error("Error! Server key invalid. Can't save chat record to Database.");
    }
    else {
        $chat = new App\Server\ChatTracker($_GET);
        $chat->track();
    }
}]);