<?php

namespace App\Http\Controllers;

use App\Game;
use App\KMatch;
use App\KTeam;
use App\KTournament;
use App\Notification;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class TManagerController extends Controller
{
    public function getCalculateMatch($slug,$id,Request $request)
    {
        $tournament = KTournament::enabled()->whereSlug($slug)->first();
        $match = KMatch::find($id);

        if(!$tournament || !$match)
            abort(404);

        //If has enough permissions or not
        if(!$request->user()->canManageTournament($tournament))
        {
            return redirect()->home();
        }

        if($match->has_been_played)
        {
            return redirect()->route('tournament.bracket.show',[$tournament->slug])->with('error',"Error! Already calculated, Plz contact admin for support");
        }

        return view('tournament.manage.getcalculate')->with('tournament',$tournament)->with('match',$match);
    }

    public function postCalculateMatch($slug,$id,Request $request)
    {
        $tournament = KTournament::enabled()->whereSlug($slug)->first();
        $match = KMatch::find($id);

        if(!$tournament || !$match)
            abort(404);

        //If has enough permissions or not
        if(!$request->user()->canManageTournament($tournament))
        {
            return redirect()->home();
        }

        if($match->has_been_played)
        {
            return redirect()->route('tournament.bracket.show',[$tournament->slug])->with('error',"Error! Already calculated, Plz contact admin for support");
        }

        $collection = new Collection();

        $i = 1;
        foreach($request->game_id as $game_id)
        {
            //If game_id is 0 means game is not played
            if($game_id == 0)
            {
                $game = new Game();
                $game->game_index = $i;
                $game->is_played = false;
            }
            else
            {
                //Get the game
                $game = Game::findOrFail($game_id);
                $game->game_index = $i;
                $game->is_played = true;
            }
            $i++;
            $collection->push($game);
        }

        //dd($collection);
        return view('tournament.manage.getcalculate2')->with('tournament',$tournament)->with('match',$match)->with('games',$collection);
    }

    /**
     * @param $slug
     * @param $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postCalculateMatchFinal($slug,$id,Request $request)
    {
        $tournament = KTournament::enabled()->whereSlug($slug)->first();
        $match = KMatch::find($id);

        if (!$tournament || !$match)
            abort(404);

        //If has enough permissions or not
        if (!$request->user()->canManageTournament($tournament)) {
            return redirect()->home();
        }

        if($match->has_been_played)
        {
            return redirect()->route('tournament.bracket.show',[$tournament->slug])->with('error',"Error! Already calculated, Plz contact admin for support");
        }

        if($request->overall_winner_id == "0" && $tournament->bracket_type > 0)
        {
            return redirect()->route('tournament.bracket.show',[$tournament->slug])->with('error',"Error! Tie only supported in Round Robin Tournament");
        }


        // Check is On. Turn off only for testing
        if(true)
        {
            //Check if all team1_p1_score is present
            foreach($request->team1_p1_score as $x)
            {
                if($x==null || $x=="")
                {
                    return redirect()->route('tournament.match.getcalculate',[$tournament->slug,$match->id])->with('error',"Error! Something is not correct. Please retry.");
                }
            }
            //Check if all team1_p2_score is present
            foreach($request->team1_p2_score as $x)
            {
                if($x==null || $x=="")
                {
                    return redirect()->route('tournament.match.getcalculate',[$tournament->slug,$match->id])->with('error',"Error! Something is not correct. Please retry.");
                }
            }
            //Check if all team2_p1_score is present
            foreach($request->team2_p1_score as $x)
            {
                if($x==null || $x=="")
                {
                    return redirect()->route('tournament.match.getcalculate',[$tournament->slug,$match->id])->with('error',"Error! Something is not correct. Please retry.");
                }
            }
            //Check if all team2_p2_score is present
            foreach($request->team2_p2_score as $x)
            {
                if($x==null || $x=="")
                {
                    return redirect()->route('tournament.match.getcalculate',[$tournament->slug,$match->id])->with('error',"Error! Something is not correct. Please retry.");
                }
            }

            if($tournament->tournament_type == 2) // if 3v3
            {
                //Check if all team1_p3_score is present
                foreach($request->team1_p3_score as $x)
                {
                    if($x==null || $x=="")
                    {
                        return redirect()->route('tournament.match.getcalculate',[$tournament->slug,$match->id])->with('error',"Error! Something is not correct. Please retry.");
                    }
                }
                //Check if all team2_p3_score is present
                foreach($request->team2_p3_score as $x)
                {
                    if($x==null || $x=="")
                    {
                        return redirect()->route('tournament.match.getcalculate',[$tournament->slug,$match->id])->with('error',"Error! Something is not correct. Please retry.");
                    }
                }
            }

            //Check if all team1_p1_score is present
            foreach($request->winner as $x)
            {
                if($x==null || $x=="")
                {
                    return redirect()->route('tournament.match.getcalculate',[$tournament->slug,$match->id])->with('error',"Error! Something is not correct. Please retry.");
                }
            }
        }

        // Now Insertions will be here...

        //First insert game_id in Match Table
        //Check if all game_id is present
        $i = 1;
        foreach($request->game_id as $x)
        {
            $match->{"game".$i."_id"} = $x;
            $i++;
        }

        /**
         * GAME WIN OUTCOMES
         * 0 -> Team 1 Wins
         * 1 -> Team 2 Wins
         * 2 -> A Tie
         * 3 -> None
         */
        $team1_w = 0;
        $team2_w = 0;
        $tie_w = 0;
        $no_w = 0;

        $i = 1;
        foreach($request->winner as $x)
        {
            $match->{"game".$i."_id_outcome"} = $x;
            $i++;

            switch($x)
            {
                case 0:
                    $team1_w++;
                    break;
                case 1:
                    $team2_w++;
                    break;
                case 2:
                    $tie_w++;
                    break;
                case 3:
                    $no_w++;
                    break;
                default:
                    break;
            }
        }

        if($team1_w > $team2_w)
        {
            $match->winner_team_won_by = $team1_w." - ".$team2_w;
        }
        else
        {
            $match->winner_team_won_by = $team2_w." - ".$team1_w;
        }

        /*$collection = collect($request->winner);
        $items = ($collection->groupBy(function($item,$key){
            return $item;
        }));

        dd($match->winner_team_won_by);
        foreach($items as $item)
        {
            dd($item->count());
        }*/

        /**
         * If tournament type is 3v3 then take 3 players else only 2
         * @TODO: Change if 1v1 implemented
         */
        if($tournament->tournament_type == 2) //3v3
        {
            $team1_p1_score_sum = array_sum($request->team1_p1_score);
            $team1_p2_score_sum = array_sum($request->team1_p2_score);
            $team1_p3_score_sum = array_sum($request->team1_p3_score);
            $team2_p1_score_sum = array_sum($request->team2_p1_score);
            $team2_p2_score_sum = array_sum($request->team2_p2_score);
            $team2_p3_score_sum = array_sum($request->team2_p3_score);

            $team1_total_score = $team1_p1_score_sum + $team1_p2_score_sum + $team1_p3_score_sum;
            $team2_total_score = $team2_p1_score_sum + $team2_p2_score_sum + $team2_p3_score_sum;
        }
        else
        {
            $team1_p1_score_sum = array_sum($request->team1_p1_score);
            $team1_p2_score_sum = array_sum($request->team1_p2_score);
            $team2_p1_score_sum = array_sum($request->team2_p1_score);
            $team2_p2_score_sum = array_sum($request->team2_p2_score);

            $team1_total_score = $team1_p1_score_sum + $team1_p2_score_sum;
            $team2_total_score = $team2_p1_score_sum + $team2_p2_score_sum;
        }

        $match->k_team1_total_score = $team1_total_score;
        $match->k_team2_total_score = $team2_total_score;

        if($request->overall_winner_id != "-1" && $request->overall_winner_id != "0" && $request->overall_winner_id != $match->team1->id && $request->overall_winner_id != $match->team2->id)
        {
            return redirect()->home()->with("error","Error! Don't mess up with codes.");
        }
        $match->winner_team_id = $request->overall_winner_id;
        $match->has_been_played = true;

        //SAVE MATCH
        $match->save();

        $team1 = $match->team1;
        $team2 = $match->team2;
        $team1->total_score += $team1_total_score;
        $team2->total_score += $team2_total_score;
        //If winner is team 1
        if($request->overall_winner_id == $team1->id)
        {
            $team1->total_wins += 1;
            $team2->total_lost += 1;

            $team1->points += 2;
            $team2->points -= 2;
        }
        // If team 2 is winner
        elseif($request->overall_winner_id == $team2->id)
        {
            $team2->total_wins += 1;
            $team1->total_lost += 1;

            $team2->points += 2;
            $team1->points -= 2;
        }
        // A Tie
        elseif($request->overall_winner_id == "0")
        {
            $team2->total_tie += 1;
            $team1->total_tie += 1;

            $team1->points += 1;
            $team2->points += 1;
        }
        // nothing
        else
        {

        }

        //SAVE TEAMS
        $team1->save();
        $team2->save();

        //SAVE INDI PLAYER STATS
        if($tournament->tournament_type == 0)   //OK for 2v2
        {
            $team1_p1 = $match->team1->playerselected->first();
            $team1_p2 = $match->team1->playerselected->last();
            $team2_p1 = $match->team2->playerselected->first();
            $team2_p2 = $match->team2->playerselected->last();

            $match->team1->givescoretouser($team1_p1,$team1_p1_score_sum);
            $match->team1->givescoretouser($team1_p2,$team1_p2_score_sum);
            $match->team2->givescoretouser($team2_p1,$team2_p1_score_sum);
            $match->team2->givescoretouser($team2_p2,$team2_p2_score_sum);
        }
        else if($tournament->tournament_type == 2)
        {
            $i=1;
            foreach ($match->team1->playerselected as $player)
            {
                //${'team1_p'.$i} = $player;
                $match->team1->givescoretouser($player,${'team1_p'.$i.'_score_sum'});
                $i++;
            }

            $y=1;
            foreach ($match->team2->playerselected as $player)
            {
                //${'team2_p'.$i} = $player;
                $match->team2->givescoretouser($player,${'team2_p'.$y.'_score_sum'});
                $y++;
            }
        }
        //@TODO: Add else here for 1v1


        //FOR DE/SE ONLY
        //Check all match id (TBA) and change to team id as per match schedule
        if($tournament->bracket_type > 0)
        {
            // Check for all matches with has this match index for team 1...
            $team1_from_match_indexes = KMatch::where('team1_from_match_index',$match->match_index)->get();
            foreach($team1_from_match_indexes as $team1_from_match_index)
            {
                if($team1_from_match_index->team1_from_match_rank == 1) //Get winner of this round
                {
                    $team1_from_match_index->k_team1_id = $match->winner_team_id;
                    $team1_from_match_index->save();
                }
                elseif($team1_from_match_index->team1_from_match_rank == 2) //Get the loser of this round
                {
                    $team1_from_match_index->k_team1_id = $team1->id == $match->winner_team_id ? $team2->id : $team1->id;
                    $team1_from_match_index->save();
                }
            }

            // Check for all matches with has this match index for team 2...
            $team2_from_match_indexes = KMatch::where('team2_from_match_index',$match->match_index)->get();
            foreach($team2_from_match_indexes as $team2_from_match_index)
            {
                if($team2_from_match_index->team2_from_match_rank == 1) //Get winner of this round
                {
                    $team2_from_match_index->k_team2_id = $match->winner_team_id;
                    $team2_from_match_index->save();
                }
                elseif($team2_from_match_index->team2_from_match_rank == 2) //Get the loser of this round
                {
                    $team2_from_match_index->k_team2_id = $team1->id == $match->winner_team_id ? $team2->id : $team1->id;
                    $team2_from_match_index->save();
                }
            }
        }

        //Dispatch Notifications
        //If match is cancelled
        if($request->winner_team_id == "-1")
        {
            // Create notification with Stream
            $not = new Notification();
            $not->from($request->user())
                ->withType('TournamentMatchCancelled')
                ->withSubject('Match is cancelled in a tournament')
                ->withBody(link_to_route('tournament.show',$tournament->name,$tournament->slug)." : Match between ".link_to_route('tournament.team.show',$match->team1->name,[$tournament->slug,$match->team1->id])." and ".link_to_route('tournament.team.show',$match->team2->name,[$tournament->slug,$match->team2->id])." was <span class='text-danger notify-bold'>cancelled</span>")
                ->withStream(true)
                ->regarding($tournament)
                ->deliver();
        }
        else if($request->winner_team_id == "0")
        {
            $not = new Notification();
            $not->from($request->user())
                ->withType('TournamentMatchTie')
                ->withSubject('Match is tie in a tournament')
                ->withBody(link_to_route('tournament.show',$tournament->name,$tournament->slug)." : Match between ".link_to_route('tournament.team.show',$match->team1->name,[$tournament->slug,$match->team1->id])." and ".link_to_route('tournament.team.show',$match->team2->name,[$tournament->slug,$match->team2->id])." <span class='text-danger notify-bold'>tied</span> by ".$request->winner_team_won_by)
                ->withStream(true)
                ->regarding($tournament)
                ->deliver();
        }
        else
        {
            $not = new Notification();
            $not->from($request->user())
                ->withType('TournamentMatchPlayed')
                ->withSubject('Match is played in a tournament')
                ->withBody(link_to_route('tournament.show',$tournament->name,$tournament->slug)." : ".$match->getWinningTextForNotifications())
                ->withStream(true)
                ->regarding($tournament)
                ->deliver();
        }

        //RANK THE TEAMS
        //@TODO: Its TEMP CHANGE IT
        $teams = KTeam::where('team_status',1)->orderBy('points','desc')->orderBy('total_wins','desc')->orderBy('total_lost','asc')->orderBy('total_tie','desc')->orderBy('total_score','desc')->get();
        $i=0;
        foreach($teams as $team)
        {
            $team->team_position = ++$i;
            $team->save();
        }

        return redirect()->route('tournament.show',[$tournament->slug])->with('message',"Success! Match data has been recorded.");
    }

    //update screenshots of match
    public function postUploadShots($slug,$id,Request $request)
    {
        $tournament = KTournament::enabled()->whereSlug($slug)->first();
        $match = KMatch::find($id);

        if (!$tournament || !$match)
            abort(404);

        //If has enough permissions or not
        if (!$request->user()->canManageTournament($tournament)) {
            return redirect()->home();
        }

        $i1 = $request->game1_screenshot == "" ? null : $request->game1_screenshot;
        $i2 = $request->game2_screenshot == "" ? null : $request->game2_screenshot;
        $i3 = $request->game3_screenshot == "" ? null : $request->game3_screenshot;
        $i4 = $request->game4_screenshot == "" ? null : $request->game4_screenshot;

        $match->game1_screenshot = $i1;
        $match->game2_screenshot = $i2;
        $match->game3_screenshot = $i3;
        $match->game4_screenshot = $i4;

        $match->save();

        return back()->with('message','Screenshots updated');
    }
}
