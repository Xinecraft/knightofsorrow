<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Game;

class StatisticsController extends Controller
{

    public function getRoundReports()
    {
        $rounds = Game::orderBy('created_at','DESC')->paginate(10);

        return view('statistics.round-reports')->with('rounds', $rounds);
    }

    public function getTopPlayers()
    {
        return Player::paginate(10);
    }
}
