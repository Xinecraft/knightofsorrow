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

Route::get('/', ['as' => 'home', function () {
/*
    $data1 = '{"0":"DUYFu8ao","1":"1.0.0","2":"10480","3":"1437386880","4":"11cc6f19","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19371","16":"569","17":"900","19":"1","21":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"86","11":"1","17":"1","38":"4"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"71","8":"1","9":"1","15":"1","38":"2"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"66","38":"2"}]}';

    $data2 = '{"0":"AIq1F3LG","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19301","16":"499","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"19"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"4"}]}';

    $data3 = '{"0":"FTuq4Tox","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19331","16":"529","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"48","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"33","38":"1"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"28","38":"1"}]}';

    $data4 = '{"0":"aoCjMXOs","1":"1.0.0","2":"10480","3":"1437386940","4":"6512549a","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19457","16":"656","17":"900","19":"1","20":"11","21":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","2":"1","5":"YUG_X_Gmr","7":"98","11":"1","17":"1","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"154","8":"1","9":"1","11":"1","14":"2","15":"1","17":"1","38":"2"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"149","8":"10","13":"2","16":"2","38":"2"},{"0":"6","1":"182.181.184.161","5":"YUG_X_Gmr","7":"58","8":"1","9":"1","15":"1","38":"2"}]}';

    $data5 = '{"0":"gZzV5JGQ","1":"1.0.0","2":"10480","3":"1437386880","4":"11cc6f19","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19362","16":"560","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"77","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"62","38":"2"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"58","38":"2"}]}';

    $data6 = '{"0":"hdr5q4FG","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19343","16":"541","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"60","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"44","38":"2"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"40","38":"2"}]}';

    $data6 = '{"0":"jWO6l3xa","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19339","16":"537","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"56","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"40","38":"2"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"36","38":"2"}]}';

    $data7 = '{"0":"kZ4Jk2DK","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19334","16":"532","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"51","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"36","38":"2"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"32","38":"2"}]}';

    $data8 = '{"0":"yTuq4Toy","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19331","16":"529","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"48","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"33","38":"1"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"28","38":"1"}]}';

    $data9 = '{"0":"gcqo6buP","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19331","16":"529","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"48","38":"2"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"33","38":"1"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo","7":"28","38":"1"}]}';

    $data10 = '{"0":"rTjAGcAF","1":"1.0.0","2":"10480","3":"1437386820","4":"481b525e","6":"1.0","7":"[c=FFFF00]WWW.KNIGHTofSORROW.TK (Antics)","11":"3","12":"12","13":"1","14":"5","15":"19301","16":"499","17":"900","19":"1","22":"0","27":[{"0":"0","1":"182.185.80.115","2":"1","5":"YUG_X_Gmr","7":"67","38":"2"},{"0":"1","1":"182.185.83.84","2":"1","5":"YUG_X_Gmr","7":"139"},{"0":"2","1":"182.181.216.180","2":"1","5":"||KhaN||Namo(VIEW)","7":"247","11":"1","17":"1","38":"4"},{"0":"3","1":"182.181.184.161","5":"YUG_X_Gmr","7":"20"},{"0":"4","1":"182.185.27.16","5":"RainBoW","6":"1","7":"4"},{"0":"5","1":"182.181.216.180","5":"||KhaN||_Namo"}]}';


    $s1 = new App\Server\ServerTracker(json_decode($data1,true));
    $s2 = new App\Server\ServerTracker(json_decode($data2,true));
    $s3 = new App\Server\ServerTracker(json_decode($data3,true));
    $s4 = new App\Server\ServerTracker(json_decode($data4,true));
    $s5 = new App\Server\ServerTracker(json_decode($data5,true));
    $s6 = new App\Server\ServerTracker(json_decode($data6,true));
    $s7 = new App\Server\ServerTracker(json_decode($data7,true));
    $s8 = new App\Server\ServerTracker(json_decode($data8,true));
    $s9 = new App\Server\ServerTracker(json_decode($data9,true));
    $s10 = new App\Server\ServerTracker(json_decode($data10,true));
    $s1->track();
    $s2->track();
    $s3->track();
    $s4->track();
    $s5->track();
    $s6->track();
    $s7->track();
    $s8->track();
    $s9->track();
    $s10->track();
    */

    $alias = App\Alias::with('players')->first();
    $playerTotal = new App\PlayerTotal();
    $playerTotal->name = $alias->name;
    $playerTotal->alias_id = $alias->id;
    $playerTotal->profile_id = $alias->profile_id;
    $playerTotal->last_loadout_id = $alias->profile->loadout_id;
    $playerTotal->last_team = $alias->profile->team;
    $playerTotal->first_game_id = $alias->profile->game_first;
    $playerTotal->last_game_id = $alias->profile->game_last;
    $playerTotal->country_id = $alias->profile->country_id;

    $playersCollection = $alias->players;
    $playerTotal->is_admin = $playersCollection->max('is_admin');
    $playerTotal->total_score = $playersCollection->sum('score');
    $playerTotal->highest_score = $playersCollection->max('score');
    $playerTotal->total_time_played = $playersCollection->sum('time_played');
    $playerTotal->total_kills = $playersCollection->sum('kills');
    $playerTotal->total_team_kills = $playersCollection->sum('team_kills');
    $playerTotal->total_deaths = $playersCollection->sum('deaths');
    $playerTotal->total_suicides = $playersCollection->sum('suicides');
    $playerTotal->total_arrests = $playersCollection->sum('arrests');
    $playerTotal->total_arrested = $playersCollection->sum('arrested');
    $playerTotal->best_killstreak = $playersCollection->max('kill_streak');
    $playerTotal->best_deathstreak = $playersCollection->max('death_streak');
    $playerTotal->best_arreststreak = $playersCollection->max('arrest_streak');
    $playerTotal->total_round_played = $playersCollection->unique('game_id')->count('game_id');
    $playerTotal->last_ip_address = $alias->ip_address;


    dd($totalScore);

    $won = 0;
    $lost = 0;
    $draw = 0;
    foreach($playersCollection->unique('game_id') as $player)
    {
        switch($player->game->isWinner($player->team))
        {
            case 0:
                $lost++;
                break;
            case 1:
                $won++;
                break;
            case -1:
                $draw++;
                break;
            default:
                break;
        }
    }
    $playerTotal->game_won = $won;
    $playerTotal->game_lost = $lost;
    $playerTotal->game_draw = $draw;
    $playerTotal->total_points = max(($playerTotal->total_kills * 4) + ($playerTotal->total_arrests * 13) - ($playerTotal->total_deaths) - ($playerTotal->total_arrested * 3) - ($playerTotal->total_team_kills * 2),0);

    //dd($playerTotal->total_time_played/60/60);
    $rank = App\Rank::where('rank_points','>=',$playerTotal->total_points)->orderBy('rank_points')->first();
    //dd(App\PlayerTotal::orderBy('player_rating','DESC')->orderBy('total_points','DESC')->orderBy('total_score','DESC')->get());

}]);

Route::get('user','UserController@index');

Route::group(['prefix' => 'statistics'],function(){
    Route::get('round-reports','StatisticsController@getRoundReports');
    Route::get('top-players','StatisticsController@getTopPlayers');
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