<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerPoint extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'points', 'reason', 'admin_id', 'k_tournament_id', 'player_total_id'];

    /**
     * Creator of this point reward
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo('App\User', 'admin_id', 'id');
    }

    /**
     * Belonging PlayerTotal Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player()
    {
        return $this->belongsTo('App\PlayerTotal', 'player_total_id', 'id');
    }
}
