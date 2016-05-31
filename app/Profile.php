<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['ip_address'];

    /**
     * Returns all the Alias of the given profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aliases()
    {
        return $this->hasMany('App\Alias');
    }

    /**
     * Returns the Country of the given Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * Returns the last wore loadout of the given profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function loadout()
    {
        return $this->belongsTo('App\Loadout');
    }

    /**
     * Returns the first game played by the profile holder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function firstGame()
    {
        return $this->belongsTo('App\Game','game_first');
    }

    /**
     * Returns the last game played by the profile holder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastGame()
    {
        return $this->belongsTo('App\Game','game_last','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function playerTotals()
    {
        return $this->hasMany('App\PlayerTotal');
    }

    /**
     * @return mixed
     */
    public function players()
    {
        return $this->hasManyThrough('App\Player','App\Alias');
    }
}
