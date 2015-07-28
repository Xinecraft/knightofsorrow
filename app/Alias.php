<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{
    protected $fillable = ['name'];

    /**
     * Returns all players with this Alias
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany('App\Player');
    }

    /**
     * Returns the profile with this alias belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    /**
     * Returns one belonging PlayerTotal with this Alias
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function playerTotal()
    {
        return $this->hasOne('App\PlayerTotal');
    }

    /**
     * Returns all weapons stats ever used by the player with this Alias.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function weapons()
    {
        return $this->hasManyThrough('App\Weapon','App\Player');
    }
}