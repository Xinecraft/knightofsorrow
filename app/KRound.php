<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRound extends Model
{
    protected  $fillable = ['k_tournament_id','round_index','no_of_matches'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matches()
    {
        return $this->hasMany('App\KMatch','k_round_id');
    }
}
