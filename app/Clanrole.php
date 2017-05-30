<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clanrole extends Model
{
    /**
     * The users that belong to the clan role.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
