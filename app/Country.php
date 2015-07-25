<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * Returns all player with given country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany('App\Player');
    }

    /**
     * Returns all PlayerTotal with this Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function playerTotals()
    {
        return $this->hasMany('App\PlayerTotal');
    }

    /**
     * Returns all profile with given country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profiles()
    {
        return $this->hasMany('App\Profile');
    }
}