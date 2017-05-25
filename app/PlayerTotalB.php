<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Server\Presenters\PlayerTotalPresenter;
use App\PlayerTotal;

class PlayerTotalB extends Model
{
    /**
     * Returns the Alias instance of the current Player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alias()
    {
        return $this->belongsTo('App\Alias');
    }

    public function aliases()
    {
        return $this->profile->aliases();
    }

    /**
     * Returns the Profile instance of the current Player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    /**
     * Returns Country instance to which this Player belongs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * Returns the Rank of this Player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rank()
    {
        return $this->belongsTo('App\Rank');
    }

    /**
     * Returns the last Valid loadout of the Player.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function loadout()
    {
        return $this->belongsTo('App\Loadout','last_loadout_id');
    }

    /**
     * Returns the first Game played by this Player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function firstGame()
    {
        return $this->belongsTo('App\Game','first_game_id');
    }

    /**
     * Returns the last Game played by this Player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastGame()
    {
        return $this->belongsTo('App\Game','last_game_id');
    }

    /**
     * User who is owner of this account.
     *
     * @return User
     */
    public function user()
    {
        return User::where('player_totals_name','LIKE',"$this->name")->first();
    }

    /**
     * Find a PlayerTotal using its name.
     * PlayerTotal::findOrFailByName($name);
     *
     * @param $name
     * @return Collection
     */
    public static function findOrFailByName($name)
    {
        $player = self::whereName($name)->first();
        if($player == null)
            throw new ModelNotFoundException;
        else
            return $player;
    }

    /**
     * Find a PlayerTotal using its name.
     * PlayerTotal::findOrFailByName($name);
     *
     * @param $name
     * @return Collection
     */
    public static function findOrFailByNameWithNull($name)
    {
        $player = self::whereName($name)->first();
        return $player;
    }


    /**
     * Returns a Collection for all weapons..
     *
     * @return \Illuminate\Support\Collection
     */
    public function AllWeapons()
    {
        $weapons_data = $this->alias->weapons->sortBy('name')->groupBy('name');

        $weaponTotal = new \Illuminate\Support\Collection();
        $weaponTotal->primary = new \Illuminate\Support\Collection();
        $weaponTotal->secondary = new \Illuminate\Support\Collection();
        $weaponTotal->tactical = new \Illuminate\Support\Collection();
        $weaponTotal->others = new \Illuminate\Support\Collection();

        foreach($weapons_data as $key => $weapons)
        {
            if(in_array($key,[1,2,4,5,6,7,8,9,10,11,12]))
            {
                $weaponTotal->primary->$key = new \Illuminate\Support\Arr();
                $weaponTotal->primary->push($weaponTotal->primary->$key);

                $weaponTotal->primary->$key->family = "Primary";
                $weaponTotal->primary->$key->name  = Server\Utils::getEquipmentTitleById($key);
                $weaponTotal->primary->$key->id = $key;
                $weaponTotal->primary->$key->shots_fired = $weapons->sum('shots_fired');
                $weaponTotal->primary->$key->shots_hit = $weapons->sum('shots_hit');
                $weaponTotal->primary->$key->kills = $weapons->sum('kills');
                $weaponTotal->primary->$key->accuracy = $weaponTotal->primary->$key->shots_fired == 0 ? 0 : round(( $weaponTotal->primary->$key->shots_hit / $weaponTotal->primary->$key->shots_fired ) * 100,2);
                $weaponTotal->primary->$key->kills_per_min = $weapons->sum('seconds_used') == 0 ? 0 : round(($weaponTotal->primary->$key->kills / $weapons->sum('seconds_used'))*60,2);
                $weaponTotal->primary->$key->distance = $weapons->max('distance');
                $weaponTotal->primary->$key->time_used = Server\Utils::getHMbyS($weapons->sum('seconds_used'),"%dh %dm");

            }
            elseif(in_array($key,[13,14,15,16,17]))
            {
                $weaponTotal->secondary->$key = new \Illuminate\Support\Arr();
                $weaponTotal->secondary->push($weaponTotal->secondary->$key);

                $weaponTotal->secondary->$key->family = "Secondary";
                $weaponTotal->secondary->$key->name  = Server\Utils::getEquipmentTitleById($key);
                $weaponTotal->secondary->$key->id = $key;
                $weaponTotal->secondary->$key->shots_fired = $weapons->sum('shots_fired');
                $weaponTotal->secondary->$key->shots_hit = $weapons->sum('shots_hit');
                $weaponTotal->secondary->$key->kills = $weapons->sum('kills');
                $weaponTotal->secondary->$key->accuracy = $weaponTotal->secondary->$key->shots_fired == 0 ? 0 : round(( $weaponTotal->secondary->$key->shots_hit / $weaponTotal->secondary->$key->shots_fired ) * 100,2);
                $weaponTotal->secondary->$key->kills_per_min = $weapons->sum('seconds_used') == 0 ? 0 : round(($weaponTotal->secondary->$key->kills / $weapons->sum('seconds_used'))*60,2);
                $weaponTotal->secondary->$key->distance = $weapons->max('distance');
                $weaponTotal->secondary->$key->time_used = Server\Utils::getHMbyS($weapons->sum('seconds_used'),"%dh %dm");
            }
            elseif(in_array($key,[18,23,24,45,25,26]))
            {
                $weaponTotal->tactical->$key = new \Illuminate\Support\Arr();
                $weaponTotal->tactical->push($weaponTotal->tactical->$key);

                $weaponTotal->tactical->$key->family = "Tactical";
                $weaponTotal->tactical->$key->name  = Server\Utils::getEquipmentTitleById($key);
                $weaponTotal->tactical->$key->id = $key;
                $weaponTotal->tactical->$key->shots_fired = $weapons->sum('shots_fired');
                $weaponTotal->tactical->$key->shots_hit = $weapons->sum('shots_hit');
                $weaponTotal->tactical->$key->kills = $weapons->sum('kills');
                $weaponTotal->tactical->$key->accuracy = $weaponTotal->tactical->$key->shots_fired == 0 ? 0 : round(( $weaponTotal->tactical->$key->shots_hit / $weaponTotal->tactical->$key->shots_fired ) * 100,2);
                $weaponTotal->tactical->$key->stuns_per_min = $weapons->sum('seconds_used') == 0 ? 0 : round(($weaponTotal->tactical->$key->shots_fired / $weapons->sum('seconds_used'))*60,2);
                $weaponTotal->tactical->$key->distance = $weapons->max('distance');
                $weaponTotal->tactical->$key->time_used = Server\Utils::getHMbyS($weapons->sum('seconds_used'),"%dh %dm");
            }
            else
            {
                $weaponTotal->others->$key = new \Illuminate\Support\Arr();
                $weaponTotal->others->push($weaponTotal->others->$key);

                $weaponTotal->others->$key->family = "Others";
                $weaponTotal->others->$key->name  = Server\Utils::getEquipmentTitleById($key);
                $weaponTotal->others->$key->id = $key;
                $weaponTotal->others->$key->shots_fired = $weapons->sum('shots_fired');
                $weaponTotal->others->$key->shots_hit = $weapons->sum('shots_hit');
                $weaponTotal->others->$key->kills = $weapons->sum('kills');
                $weaponTotal->others->$key->accuracy = $weaponTotal->others->$key->shots_fired == 0 ? 0 : round(( $weaponTotal->others->$key->shots_hit / $weaponTotal->others->$key->shots_fired ) * 100,2);
                $weaponTotal->others->$key->kills_per_min = $weapons->sum('seconds_used') == 0 ? 0 : round(($weaponTotal->others->$key->kills / $weapons->sum('seconds_used'))*60,2);
                $weaponTotal->others->$key->distance = $weapons->max('distance');
                $weaponTotal->others->$key->time_used = Server\Utils::getHMbyS($weapons->sum('seconds_used'),"%dh %dm");
            }
        }

        $weaponTotal->push($weaponTotal->primary->sortByDesc('kills'))->push($weaponTotal->secondary->sortByDesc('kills'))->push($weaponTotal->tactical->sortByDesc('shots_fired'))->push($weaponTotal->others->sortByDesc('kills'));

        return $weaponTotal;
    }


    /**
     * Returns game ID of last 5 rounds played
     *
     * @return mixed
     */
    public function lastRounds()
    {
        return $this->alias->players->sortByDesc('game_id')->unique('game_id')->take(5)->pluck('game_id');
    }

    /**
     * A scope function for getCountry help.
     *
     * @return mixed
     */
    public function scopeCountryAggregate()
    {
        return $this->with('country')->select(\DB::raw("count(id) as total_players,country_id,sum(total_score) as total_score,sum(total_points) as total_points,sum(total_time_played) as total_time_played"))->groupBy('country_id');
    }

    /**
     * Check if player is already claimed.
     *
     * @param $name
     * @return mixed
     */
    public static function isClaimed($name)
    {
        return \App\User::where('player_totals_name','LIKE',$name)->first();
    }

    /**
     * Awarded points
     */
    public function playerPoints()
    {
        return $this->hasMany('App\PlayerPoint', 'player_total_id', 'id');
    }

    public static function todaycount()
    {
        $time24 = \Carbon\Carbon::parse('24 hour ago');
        try
        {
            $game = \App\Game::where('created_at','>=', $time24)->first()->id;
            return self::where('last_game_id','>=',$game)->count();
        }
        catch (\Exception $e)
        {
            return 0;
        }

    }
}
