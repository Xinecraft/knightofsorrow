<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pollo extends Model
{
    protected $fillable = ['option'];

    protected $with = ['users'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pollq()
    {
        return $this->belongsTo('App\Pollq');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
