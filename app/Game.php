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
}
