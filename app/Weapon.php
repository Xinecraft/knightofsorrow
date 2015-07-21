<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    public function player()
    {
        return $this->belongsTo('App\Player');
    }
}
