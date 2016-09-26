<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function alias()
    {
        return $this->belongsTo('App\Alias');
    }

    public function loadout()
    {
        return $this->belongsTo('App\Loadout');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function weapons()
    {
        return $this->hasMany('App\Weapon');
    }

    public function getScorePerMinAttribute()
    {
        return round($this->score/($this->time_played/60),2);
    }

    public function getBestIn($fields,$orderBy,$timeAgo='1915-07-26 16:19:44')
    {
        //SELECT name,SUM(kills) as killss,SUM(deaths),SUM(arrests) FROM `players` GROUP BY name ORDER BY killss DESC
        return $this->select(\DB::raw('*,'.$fields))->where('created_at','>=', $timeAgo)->whereNotIn('name',DeletedPlayer::lists('player_name'))->groupBy('name')->orderBy($orderBy,'DESC')->first();
    }

    /**
     * Returns playerTotal if player has a playerTotal
     * else returns a stdClass with id set to 0
     *
     * @return stdClass or PlayerTotal
     */
    public function playerTotal()
    {
        $pt = $this->alias->playerTotal();
        if($pt->first() == null)
        {
            $pt = new \stdClass();
            $pt->id = 0;
            $pt->name = "Unknown";
            $pt->rank = new \stdClass();
            $pt->rank->id = 1;
            $pt->rank->shortname = 'NON';
            $pt->rank->name = "None";
            return $pt;
        }
        return $pt->first();
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
        $player = self::whereName($name)->take(1)->first();
        return $player;
    }

}
