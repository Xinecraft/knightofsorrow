<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Pollq extends Model
{
    protected $fillable = ['question', 'closed_at'];

    protected $dates = ['closed_at'];

    protected $with = ['pollos'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pollos()
    {
        return $this->hasMany('App\Pollo');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function users()
    {
        $pollos = $this->pollos()->with('users')->get();

        $vol = new \Illuminate\Database\Eloquent\Collection;

        foreach($pollos as $pollo)
        {
            $vol = $vol->merge($pollo->users);
        }

        return $vol;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function hasVoted(User $user)
    {
        foreach($this->pollos as $pollo)
        {
             if($pollo->users->contains($user->id))
                 return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isVoted()
    {
        if(Auth::check())
            return $this->hasVoted(Auth::user());

        return true;
    }

    public function isExpired()
    {
        return Carbon::now() >= $this->closed_at;
    }
}
