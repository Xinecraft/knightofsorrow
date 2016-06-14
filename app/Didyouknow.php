<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Didyouknow extends Model
{
    protected $fillable = ['body'];

    /**
     * Submitter User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
