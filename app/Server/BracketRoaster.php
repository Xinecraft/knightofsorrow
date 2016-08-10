<?php

namespace App\Server;

use App\KMatch;
use App\KTournament;
use Carbon\Carbon;


class BracketRoaster
{

    /**
     * BracketRoaster constructor.
     */
    public function __construct()
    {
    }

    /**
     * Generate Round Robin Matches for given tournament.
     *
     * @param KTournament $tournament
     * @param bool $forced
     * @return mixed
     */
    public function roastRoundRobin(KTournament $tournament,$forced=false)
    {
        $tour = $tournament;

        //If tournament can show brackets
        if(!$tour->canShowBrackets())
        {
            return "Tournament {$tour->id} cannot show bracket\n";
        }

        // if already roasted
        if($tour->rounds()->first() && $forced == false)
        {
            return "Tournament {$tour->id} already roasted\n";
        }

        if($forced == true)
        {
            $tour->matches()->delete();
            $tour->rounds()->delete();
        }

        $teams = $tour->teams()->qualified()->get(['id'])->lists('id')->toArray();
        // No of matches played per round.
        $no_of_match_per_round = count($teams)/2;

        if (count($teams)%2 != 0){
            array_push($teams,"");
        }
        $away = array_splice($teams,(count($teams)/2));
        $home = $teams;
        for ($i=0; $i < count($home)+count($away)-1; $i++){
            for ($j=0; $j<count($home); $j++){
                $round[$i][$j]["Home"]=$home[$j];
                $round[$i][$j]["Away"]=$away[$j];
            }
            if(count($home)+count($away)-1 > 2){
                $splice = array_splice($home,1,1);
                $arr_shift = array_shift($splice);
                array_unshift($away,$arr_shift);
                array_push($home,array_pop($away));
            }
        }

        $starts_at = $tour->tournament_starts_at;
        foreach($round as $r => $games){

            //Create a round
            $roundmodel = $tour->rounds()->create([
                'round_index' => ($r+1),
                'no_of_matches' => $no_of_match_per_round,
            ]);

            $starts_at_localx = $starts_at;
            foreach($games as $play){
                // Return if a bye condition
                if($play["Home"] == "" || $play["Away"] == "")
                {
                    continue;
                }

                $starts_at_local = $starts_at_localx;

                // Create new Matches
                $matchmodel = $roundmodel->matches()->create([
                    'k_tournament_id' => $tour->id,
                    'k_team1_id' => $play["Home"],
                    'k_team2_id' => $play["Away"],
                    'starts_at' => $starts_at_local,
                ]);
                $starts_at_local = $starts_at_local->addHour();
            }

            // Add 1 day for each next rounds
            $starts_at_localx = $starts_at_localx->subHour($no_of_match_per_round);
            $starts_at = $starts_at->addDay();
        }
        return "New tournaments roasted!\n";
    }

    public function checkRoastRobinAll()
    {
        $tournaments = KTournament::enabled()->get();
        $info = "";
        foreach($tournaments as $tournament)
        {
            $info = $info.$this->roastRoundRobin($tournament);
        }
        return $info;
    }
}