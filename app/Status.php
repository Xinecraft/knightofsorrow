<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;
use App\Server\Presenters\StatusPresenter;

class Status extends Model implements HasPresenter
{
    protected $fillable = ['body'];

    /**
     * @return PlayerTotalPresenter
     */
    public function getPresenterClass()
    {
        return StatusPresenter::class;
    }

    /**
     * A Status belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Returns all comments of this Status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany('App\Comment','commentable');
    }

}
