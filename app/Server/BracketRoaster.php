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

        // Turn to not eligible all teams having less than minimum required players.
        foreach($tour->teams()->qualified()->get() as $teamx)
        {
            if($teamx->isFull())
            {
                continue;
            }
            $teamx->team_status = 3; //Not Eligible
            $teamx->save();
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
                $starts_at_local = $starts_at_local->addHour(2);
            }

            // Add 1 day for each next rounds
            $starts_at_localx = $starts_at_localx->subHour($no_of_match_per_round*2);
            $starts_at = $starts_at->addDay();
        }
        return "New RR tournaments roasted!\n";
    }

    /**
     * Roast All Tourny which is not roasted
     *
     * @return string
     */
    public function checkRoastBracketsAll()
    {
        $tournaments = KTournament::enabled()->get();
        $info = "";
        foreach($tournaments as $tournament)
        {
            if($tournament->bracket_type == 0)
                $info = $info.$this->roastRoundRobin($tournament);
            else if($tournament->bracket_type == 1)
                $info = $info.$this->roastDoubleElimination($tournament);
        }
        return $info;
    }

    /**
     * Roast DE Matches for a Tournament
     * @param KTournament $tournament
     * @param bool $forced
     * @return string
     */
    public function roastDoubleElimination(KTournament $tournament,$forced=false)
    {
        $tour = $tournament;

        //If tournament can show brackets
        if(!$tour->canShowBrackets())
        {
            return "Tournament {$tour->id} cannot show bracket\n";
        }

        // if already roasted
        if($tour->matches()->first() && $forced == false)
        {
            return "Tournament {$tour->id} already roasted\n";
        }

        // If forced then deleted the roasted matches first
        if($forced == true)
        {
            $tour->matches()->delete();
        }

        // Turn to not eligible all teams having less than minimum required players.
        foreach($tour->teams()->qualified()->get() as $teamx)
        {
            if($teamx->isFull())
            {
                continue;
            }
            $teamx->team_status = 3; //Not Eligible
            $teamx->save();
        }

        // Team taking PART (only their respected IDs)
        $competitors = $tour->teams()->qualified()->get(['id'])->lists('id')->toArray();

        // Total no. of rounds to be played
        $rounds = log( count( $competitors ), 2 ) + 1;

// round one
        for( $i = 0; $i < log( count( $competitors ), 2 ); $i++ )
        {
            $seeded = array( );
            foreach( $competitors as $competitor )
            {
                $splice = pow( 2, $i );

                $seeded = array_merge( $seeded, array_splice( $competitors, 0, $splice ) );
                $seeded = array_merge( $seeded, array_splice( $competitors, -$splice ) );
            }
            $competitors = $seeded;
        }
        $events = array_chunk( $seeded, 2 );


        if( $rounds > 2 )
        {
            $round_index = count( $events );

            // second round
            for( $i = 0; $i < count( $competitors ) / 2; $i++ )
            {
                array_push( $events, array(
                    array( 'from_event_index' => $i, 'from_event_rank' => 1 ), // rank 1 = winner
                    array( 'from_event_index' => ++$i, 'from_event_rank' => 1 )
                ) );
            }

            $round_matchups = array( );
            for( $i = 0; $i < count( $competitors ) / 2; $i++ )
            {
                array_push( $round_matchups, array(
                    array( 'from_event_index' => $i, 'from_event_rank' => 2 ), // rank 2 = loser
                    array( 'from_event_index' => ++$i, 'from_event_rank' => 2 )
                ) );
            }
            $events = array_merge( $events, $round_matchups );

            for( $i = 0; $i < count( $round_matchups ); $i++ )
            {
                array_push( $events, array(
                    array( 'from_event_index' => $i + count( $competitors ) / 2, 'from_event_rank' => 2 ),
                    array( 'from_event_index' => $i + count( $competitors ) / 2 + count( $competitors ) / 2 / 2, 'from_event_rank' => 1 )
                ) );
            }
        }

        if( $rounds > 3 )
        {
            // subsequent rounds
            for( $i = 0; $i < $rounds - 3; $i++ )
            {
                $round_events = pow( 2, $rounds - 3 - $i );
                $total_events = count( $events );

                for( $j = 0; $j < $round_events; $j++ )
                {
                    array_push( $events, array(
                        array( 'from_event_index' => $j + $round_index, 'from_event_rank' => 1 ),
                        array( 'from_event_index' => ++$j + $round_index, 'from_event_rank' => 1 )
                    ) );
                }

                for( $j = 0; $j < $round_events; $j++ )
                {
                    array_push( $events, array(
                        array( 'from_event_index' => $j + $round_index + $round_events * 2, 'from_event_rank' => 1 ),
                        array( 'from_event_index' => ++$j + $round_index + $round_events * 2, 'from_event_rank' => 1 )
                    ) );
                }

                for( $j = 0; $j < $round_events / 2; $j++ )
                {
                    array_push( $events, array(
                        array( 'from_event_index' => $j + $total_events, 'from_event_rank' => 2 ),
                        array( 'from_event_index' => $j + $total_events + $round_events / 2, 'from_event_rank' => 1 )
                    ) );
                }

                $round_index = $total_events;
            }

        }

        if( $rounds > 1 )
        {
            // finals
            array_push( $events, array(
                array( 'from_event_index' => count( $events ) - 3, 'from_event_rank' => 1 ),
                array( 'from_event_index' => count( $events ) - 1, 'from_event_rank' => 1 )
            ) );
        }


        // Now save this to DB
        $starts_at_glob = $tournament->tournament_starts_at->addHour(1);

        $i = 0;

        foreach(array_chunk($events,2) as $eventx)
        {
            foreach($eventx as $event)
            {
                //Create new Match;
                $match = new KMatch();

                // Time
                $match->starts_at = $starts_at_glob;
                $starts_at_glob->addHour(2);

                //Adding of TEAM-1 of Match
                $team1 = $event[0];

                //If team is directly given ID -- in Round 1 generally
                if(!is_array($team1))
                {
                    $match->k_team1_id = $team1;
                }
                // If team is taken from Index of other match -- in DE,SE from second rounds
                else
                {
                    $match->team1_from_match_rank = $team1['from_event_rank'];
                    $match->team1_from_match_index = $team1['from_event_index'];
                }

                //Adding of TEAM-2 of Match
                $team2 = $event[1];

                //If team is directly given ID -- in Round 1 generally
                if(!is_array($team2))
                {
                    $match->k_team2_id = $team2;
                }
                // If team is taken from Index of other match -- in DE,SE from second rounds
                else
                {
                    $match->team2_from_match_rank = $team2['from_event_rank'];
                    $match->team2_from_match_index = $team2['from_event_index'];
                }
                $match->match_index = $i++;
                $tournament->matches()->create($match->toArray());
            }

            $starts_at_glob = $starts_at_glob->addDay();
            $starts_at_glob = $starts_at_glob->subHour(4);
        }

        return "New DE tournaments roasted!\n";
    }
}