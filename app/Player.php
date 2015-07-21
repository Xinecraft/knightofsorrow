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
}
