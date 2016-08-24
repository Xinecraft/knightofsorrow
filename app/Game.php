<?php

namespace App;

use App\Server\Presenters\GamePresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Game extends Model implements HasPresenter
{
    /**
     * @return GamePresenter
     */
    public function getPresenterClass()
    {
        return GamePresenter::class;
    }

    /**
     * Returns all players played that game.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany('App\Player');
    }

    /**
     * Returns all comments of this Game Round.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany('App\Comment','commentable');
    }

    /**
     * Get a team id and returns if that team won that round or not.
     *
     * Returns 0 -> Loss, 1 -> Won, -1 -> Tie -2 -> Other output or error
     *
     * @param $team
     * @return bool
     */
    public function isWinner($team)
    {
        switch($team)
        {
            case 0:
                if($this->outcome == 1)
                    return 1;
                elseif($this->outcome == 5)
                    return -1;
                elseif($this->outcome == 2)
                    return 0;
                break;
            case 1:
                if($this->outcome == 2)
                    return 1;
                elseif($this->outcome == 5)
                    return -1;
                elseif($this->coutcome == 1)
                    return 0;
                break;
            default:
                return -2;
                break;
        }
        return -2;
    }

    public function getIndexAttribute()
    {
        if(is_null($this->round_index))
            return $this->id;
        return $this->round_index;
    }

    public function getIdgoAttribue()
    {
        return $this->id." ".$this->created_at->diffForHumans();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNormal($query)
    {
        return $query->where('server_id', null);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWar($query)
    {
        return $query->where('server_id', 19);
    }


}
