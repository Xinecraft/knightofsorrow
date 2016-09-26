<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeletedPlayer extends Model
{
    protected $fillable = ['player_name','reason'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User','admin_id','id');
    }
}
