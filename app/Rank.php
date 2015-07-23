<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    public function playerTotal()
    {
        return $this->hasMany('App\PlayerTotal');
    }
}
