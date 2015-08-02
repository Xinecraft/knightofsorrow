<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','username','country_id','confirmation_token','last_ipaddress'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token','confirmation_token'];

    /**
     * A User can have many Statuses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany('App\Status')->latest();
    }

    /**
     * Returns gravatar ID
     */
    public function getGravatarId()
    {
        return md5($this->email);
    }

    /**
     * User Follower Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany [type] [description]
     */
    public function following()
    {
        return $this->belongsToMany('App\User', 'user_follows', 'follower_id', 'followed_id')->withTimestamps();
    }

    /**
     * User Followers Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany('App\User', 'user_follows', 'followed_id', 'follower_id')->withTimestamps();
    }

    /**
     * Check if user is following provided user or not
     * @param  user  $user
     * @return boolean
     */
    public function isFollowing($user)
    {
        return !$this->following->where('id',$user->id)->isEmpty();
    }

    /**
     * Make the User to follow provided User with ID
     * @param  int $userId
     * @return boolean
     */
    public function follow($userId)
    {
        $this->following()->attach($userId);
    }

    /**
     * Make the User to Unfollow the provded User with ID
     * @param  int $userId
     * @return boolean
     */
    public function unfollow($userId)
    {
        $this->following()->detach($userId);
    }

}
