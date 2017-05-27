<?php

namespace App\Http\Controllers;

use App\DeletedPlayer;
use App\PlayerPoint;
use Request;
use App\Http\Controllers\Controller;
use App\Country;
use App\Player;
use App\PlayerTotal;
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

        $rounds = Game::normal()->orderBy($orderBy,$sortDir)->paginate(35);

        return view('statistics.round-reports')->with('rounds', $rounds);
    }

    /**
     * For handling the Round Reports list table.
     *
     * @return view
     */
    public function getWarRoundReports()
    {
        $sortableColumns = ['created_at','id','round_time','swat_score','suspects_score','map_id'];

        $orderBy = Request::has('orderBy') && in_array(Request::get('orderBy'),$sortableColumns) ? Request::get('orderBy')  : 'created_at';
        $sortDir = Request::has('direction') ? Request::get('direction') : 'desc';

        $rounds = Game::war()->orderBy($orderBy,$sortDir)->paginate(35);

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
        $sortDir = Request::has('direction') ? Request::get('direction') : 'asc';

        $players = PlayerTotal::orderBy($orderBy,$sortDir)->with('country','rank','lastGame')->paginate(35);

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
    public function getPlayerDetails($name)
    {
        $player = PlayerTotal::findOrFailByName($name);
        $weapons = $player->AllWeapons();
        $latestRounds = $player->lastRounds()->toArray();

        $latestRounds = Game::findOrFail($latestRounds)->sortByDesc('created_at');

        $playerPoints = PlayerPoint::where('name',$name)->get();

        $array = [
            'player' => $player,
            'weaponFamilies' => $weapons,
            'latestGames' => $latestRounds,
            'playerPoints' => $playerPoints,
        ];

        return view('statistics.player-details',$array);
    }

    /**
     * To handle the Player Rounds view section.
     *
     * @param null $id
     * @param $name
     * @return \Illuminate\View\View
     */
    public function getPlayerRounds($name)
    {
        $player = PlayerTotal::findOrFailByName($name);
        $latestRounds = $player->allRounds()->toArray();

        $latestRounds = Game::whereIn('id',$latestRounds)->latest()->paginate(35);

        $array = [
            'player' => $player,
            'rounds' => $latestRounds,
        ];

        return view('statistics.player-rounds',$array);
    }


    /**
     * Returns a View with Country List for Statistics Page.
     *
     * @return View
     */
    public function getAllCountries()
    {

        $sortableColumns = ['total_players','total_score','total_points','total_time_played','country_id'];

        $orderBy = Request::has('orderBy') && in_array(Request::get('orderBy'),$sortableColumns) ? Request::get('orderBy')  : 'total_players';
        $sortDir = Request::has('direction') ? Request::get('direction') : 'desc';

        $players = PlayerTotal::CountryAggregate()->orderBy($orderBy,$sortDir)->paginate(35);

        $playersAll = PlayerTotal::CountryAggregate()->orderBy($orderBy,$sortDir)->get();

        $position = ($players->currentPage()-1) * 35 + 1;

        return view('statistics.countries')->with('players',$players)->with('playersAll',$playersAll)->with('position',$position);
    }

    /**
     * Get the Detail Info about individual country
     */
    public function getCountryDetails($id,$name)
    {

        $sortableColumns = ['position','rank_id','name','player_rating','total_score','total_points','total_time_played','last_game_id'];

        $orderBy = Request::has('orderBy') && in_array(Request::get('orderBy'),$sortableColumns) ? Request::get('orderBy')  : 'position';
        $sortDir = Request::has('direction') ? Request::get('direction') : 'asc';

        //$players = PlayerTotal::orderBy($orderBy,$sortDir)->paginate(10);
        $country = Country::findOrFail($id);

        $players = $country->playerTotals()->orderBy($orderBy,$sortDir)->with('country','rank','lastGame')->paginate(35);

        $array = [
            'players' => $players,
            'countryName' => $country->countryName,
            'countryId' => $country->id
        ];

        return view('statistics.country-players',$array);
    }

    public function getChartReports()
    {
        \JavaScript::put([
            'foo' => 'bar',
            'user' => \App\User::first(),
            'age' => 29
        ]);
        return view('statistics.charts');
    }

    public function getTop10()
    {
        $top10KD = PlayerTotal::where('total_kills', '>', '99')->with('country','rank','lastGame')->orderBy('killdeath_ratio','DESC')->limit(10)->get();
        $top10AAR = PlayerTotal::where('total_arrests', '>', '49')->with('country','rank','lastGame')->orderBy('arr_ratio','DESC')->limit(10)->get();
        $top10Score = PlayerTotal::orderBy('total_score','DESC')->with('country','rank','lastGame')->limit(10)->get();
        $top10Round = PlayerTotal::orderBy('total_round_played','DESC')->with('country','rank','lastGame')->limit(10)->get();
        $top10HighestScore = PlayerTotal::orderBy('highest_score','DESC')->with('country','rank','lastGame')->limit(10)->get();
        $top10Winners = PlayerTotal::orderBy('game_won','DESC')->with('country','rank','lastGame')->limit(10)->get();
        $top10KillStreak = PlayerTotal::orderBy('best_killstreak','DESC')->with('country','rank','lastGame')->limit(10)->get();
        $top10ArrestStreak = PlayerTotal::orderBy('best_arreststreak','DESC')->with('country','rank','lastGame')->limit(10)->get();

        $array = [
            'top10KD' => $top10KD,
            'top10AAR' => $top10AAR,
            'top10Score' => $top10Score,
            'top10Round' =>$top10Round,
            'top10HighestScore' => $top10HighestScore,
            'top10Winners' => $top10Winners,
            'top10KillStreak' => $top10KillStreak,
            'top10ArrestStreak' => $top10ArrestStreak,
            'position1' => 1,
            'position2' => 1,
            'position3' => 1,
            'position4' => 1,
            'position5' => 1,
            'position6' => 1,
            'position7' => 1,
            'position8' => 1,
        ];

        return view('statistics.top10',$array);
    }

    public function viewIPofPlayer()
    {
        $player = Player::where('name',\Input::get('player'))->first();

        if($player == null)
            abort(404);

        $players = Player::where('name',$player->name)->groupBy('ip_address')->latest()->get();

        return view('partials.playeriphistory')->with('players',$players);
    }

    /**
     * @param $name
     * @return \Illuminate\View\View
     */
    public function getPlayerDelete($name)
    {
        $player = Player::where('name',$name)->first();

        if($player == null || !\Auth::user()->isAdmin())
            abort(404);

        return view('statistics.delete_player')->with('player',$player);
    }

    /**
     * @param $name
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPlayerDelete($name)
    {
        $player = Player::where('name',$name)->first();

        if($player == null || !\Auth::user()->isAdmin())
            abort(404);

        if(DeletedPlayer::where('player_name',$name)->first())
        {
            return back()->with('error','Player is already Deleted');
        }

        $reason = \Input::get('reason') == "" ? null : \Input::get('reason');

        \Auth::user()->deletedPlayers()->create([
            'player_name' => $name,
            'reason' => $reason,
        ]);

        return redirect()->route('deleted-players')->with('success','Success! Player will be deleted within an hour.');
    }

    /**
     * @param $name
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPlayerUndelete($name)
    {
        $player = Player::where('name',$name)->first();

        if($player == null || !\Auth::user()->isAdmin())
            abort(404);

        if(!DeletedPlayer::where('player_name',$name)->first())
        {
            return back()->with('error','Player no longer in deleted list');
        }

        $delplayer = DeletedPlayer::where('player_name',$name)->first();
        $delplayer->delete();

        return redirect()->back()->with('success','Success! Player will be removed from deleted-list within an hour.');
    }

    /**
     * @return $this
     */
    public function getDeletedPlayersForView()
    {
        $players = DeletedPlayer::latest()->paginate();

        return view('statistics.view_deleted_players')->with('players',$players);
    }

    /**
     * @return $this
     */
    public function showExtrapoints()
    {
        $players = PlayerPoint::latest()->paginate();

        return view('playerpoints.index')->with('players',$players);
    }
}
