<?php
/**
 *
 * Copyright (c) 2014 Zishan Ansari
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * Date: 7/22/2015
 * Time: 1:08 PM
 */

namespace App\Server\Repositories;

use App\DeletedPlayer;
use App\Game;
use App\PlayerPoint;
use App\Server\Interfaces\PlayerTotalRepositoryInterface;
use App\PlayerTotalB as PlayerTotal;
use App\PlayerTotal as PlayerTotalReal;
use App\Alias;
use App\Rank;
use App\Player;
use Cache;

/**
 * Class PlayerTotalRepository
 * @package App\Server\Repositories
 */
class PlayerTotalRepository implements PlayerTotalRepositoryInterface
{
    /**
     * Deletes old player_totals table and reload everything from
     * scratches into it.
     *
     * @return string
     */
    public function calculate()
    {
        \DB::table('player_total_bs')->truncate();

        $aliases = Alias::with('players')->whereNotIn('name',DeletedPlayer::lists('player_name'))->get();
        $totalServerScore = Player::sum('score');

        foreach($aliases as $alias):
            $playerTotal = new PlayerTotal();
            $playerTotal->name = $alias->name;
            $playerTotal->alias_id = $alias->id;
            $playerTotal->profile_id = $alias->profile_id;
            /*$playerTotal->last_loadout_id = $alias->profile->loadout_id;*/
            $playerTotal->last_team = $alias->profile->team;
            //$playerTotal->first_game_id = $alias->profile->game_first;
            //$playerTotal->last_game_id = $alias->profile->game_last;

            $playerTotal->country_id = $alias->players->last()->country_id;

            $playersCollection = $alias->players;

            //Permanent Solution
            if($alias->profile->loadout->kyaKhali())
            {

                foreach($playersCollection->reverse() as $item)
                {
                    if(!$item->loadout->kyaKhali())
                    {
                        $playerTotal->last_loadout_id = $item->loadout_id;
                        break;
                    }
                    else
                    {
                        $playerTotal->last_loadout_id = $item->loadout_id;
                    }
                }
            }
            else
            {
                $playerTotal->last_loadout_id = $alias->profile->loadout_id;
            }

            $playerTotal->first_game_id =  $playersCollection->min('game_id');
            $playerTotal->last_game_id = $playersCollection->max('game_id');

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
            $playerTotal->killdeath_ratio = $playerTotal->total_deaths == 0 ? $playerTotal->total_kills : round($playerTotal->total_kills / $playerTotal->total_deaths, 2);
            $playerTotal->arr_ratio = $playerTotal->total_arrested == 0 ? $playerTotal->total_arrests : round($playerTotal->total_arrests / $playerTotal->total_arrested, 2);
            $playerTotal->score_per_min = $playerTotal->total_time_played == 0 ? $playerTotal->total_score : round($playerTotal->total_score / $playerTotal->total_time_played * 60, 2);
            $playerTotal->score_percentile = $playerTotal->total_score == 0 || $totalServerScore == 0 ? 0 : round($playerTotal->total_score / $totalServerScore * 100, 2);

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

            /**
             * This give extra points to the player from PlayerPoints Model
             */
            $playerPoints = PlayerPoint::where('name',$playerTotal->name)->get();
            if(!$playerPoints->isEmpty())
            {
                $pointsToGive = $playerPoints->sum('points');
                $playerTotal->total_points += $pointsToGive;
            }

            /**
             * Calculation of player_rating
             *
             * Calculate only if player with this alias has played more than 10 hours in server
             * and also is active and seen in last 7 days
             */

            $last_seen_game = Game::find($playerTotal->last_game_id);
            if($playerTotal->total_time_played > 60*60*10 && (\Carbon\Carbon::now()->timestamp - $last_seen_game->updated_at->timestamp) <= 60*60*24*7 )
            {
                $playerTotal->player_rating = max($playerTotal->killdeath_ratio + $playerTotal->arr_ratio + ($playerTotal->score_per_min * 1.25),0);
                $playerTotal->player_rating = min($playerTotal->player_rating,10);
            }

            /**
             * Calculation of rank_id using total_points and Rank table
             *
             * Add this if want time played(rank_seconds) also used to calculate ranks
             * ->where('rank_seconds', '<=' ,$playerTotal->total_time_played)
             *
             * Make sure that there are ranks in ranks table if not,
             * Run php artisan db:seed
             */
            $playerTotal->rank_id = Rank::where('rank_points','>=',$playerTotal->total_points)->orderBy('rank_points')->first()->id;
            $playerTotal->save();

        endforeach;

        /**
         * Getting all PlayerTotal and updating its position one by one.
         */
        $pTs = PlayerTotal::orderBy('player_rating','DESC')->orderBy('total_points','DESC')->orderBy('total_score','DESC')->get();
        $position=0;
        foreach($pTs as $pT)
        {
            $pT->position = ++$position;
            $pT->save();
        }

        // copy to the real playertotal the backup thing
        $ramdomTableName = "/var/lib/mysql-files/".'table'.str_random(10).".txt";
        $query = "SELECT * INTO OUTFILE '$ramdomTableName' FROM player_total_bs;LOAD DATA INFILE '$ramdomTableName' INTO TABLE player_totals;";
        \DB::table('player_totals')->truncate();
        \DB::connection()->getpdo()->exec($query);

        // Put to Top Player so that some bugs are fixed.
        $topPlayers = PlayerTotalReal::with(['country','rank'])->orderBy('position')->limit(10)->get();
        Cache::put('top_players',$topPlayers,31);

        return "Players total has been logged into player_total table successfully!";
    }
}
