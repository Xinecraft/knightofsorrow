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

use App\Server\Interfaces\PlayerTotalRepositoryInterface;
use App\PlayerTotal;
use App\Alias;

class PlayerTotalRepository implements PlayerTotalRepositoryInterface
{
    public function calculate()
    {
        \DB::table('player_totals')->delete();

        $aliases = Alias::with('players')->get();

        foreach($aliases as $alias):
            $playerTotal = new PlayerTotal();
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
            $playerTotal->save();
        endforeach;
    }
}