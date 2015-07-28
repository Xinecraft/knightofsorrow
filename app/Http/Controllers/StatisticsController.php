<?php

namespace App\Http\Controllers;

use App\Player;
use App\PlayerTotal;
use Request;

use App\Http\Controllers\Controller;
use App\Game;

class StatisticsController extends Controller
{

    /**
     * For handling the Round Reports list table.
     *
     * @return view
     */
    public function getRoundReports()
    {
        $sortableColumns = ['created_at','id','round_time','swat_score','suspects_score','map_id'];

        $orderBy = Request::has('orderBy') && in_array(Request::get('orderBy'),$sortableColumns) ? Request::get('orderBy')  : 'created_at';
        $sortDir = Request::has('direction') ? Request::get('direction') : 'desc';

        $rounds = Game::orderBy($orderBy,$sortDir)->paginate(15);
        return view('statistics.round-reports')->with('rounds', $rounds);
    }

    /**
     * For handling the Player(Totals) list table
     *
     * @return view
     */
    public function getTopPlayers()
    {
        $sortableColumns = ['position','country_id','rank_id','name','player_rating','total_score','total_points','total_time_played','last_game_id'];

        $orderBy = Request::has('orderBy') && in_array(Request::get('orderBy'),$sortableColumns) ? Request::get('orderBy')  : 'position';
        $sortDir = Request::has('direction') ? Request::get('direction') : 'desc';

        $players = PlayerTotal::orderBy($orderBy,$sortDir)->paginate(10);

        return view('statistics.top-players')->with('players',$players);
    }

    /**
     * For handling of a Particular Round Details.
     *
     * @param $id
     * @return $this
     */
    public function getRoundDetails($id)
    {
        $round = Game::findOrFail($id);

        return view('statistics.round-details')->with('round',$round);
    }

    /**
     * Returns Round Players Statistics with Ajax request for Round Details Section
     * @param $id
     * @return $this
     */
    public function getRoundPlayerWithAjax($id)
    {
        $player = Player::findOrFail($id);

        return view('partials._round-player-ajax')->with('player',$player);
    }


    /**
     * To handle the Player Detail view section.
     *
     * @param null $id
     * @param $name
     * @return \Illuminate\View\View
     */
    public function getPlayerDetails($id = null, $name)
    {
        $player = PlayerTotal::findOrFailByName($name);
        $weapons = $player->AllWeapons();
        $latestRounds = $player->lastRounds()->toArray();

        $latestRounds = Game::findOrFail($latestRounds)->sortByDesc('created_at');

        $array = [
            'player' => $player,
            'weaponFamilies' => $weapons,
            'latestGames' => $latestRounds
        ];

        return view('statistics.player-details',$array);
    }

}
