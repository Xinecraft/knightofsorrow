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
        return Game::orderBy('created_at','DESC')->paginate(10);
    }

    public function getTopPlayers()
    {
        return Player::paginate(10);
    }


}
