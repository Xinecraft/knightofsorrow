<?php

namespace App;

use App\Server\Presenters\UserPresenter;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use McCool\LaravelAutoPresenter\HasPresenter;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, HasPresenter
{
    use Authenticatable, CanResetPassword, EntrustUserTrait;

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

    protected $dates = ['dob'];


    /**
     * @return GamePresenter
     */
    public function getPresenterClass()
    {
        return UserPresenter::class;
    }

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
    public function getGravatarLink($size)
    {
         //gravatar.com/avatar/{id}?d=mm&s=20
        $id = md5($this->email);
        $link = "//gravatar.com/avatar/$id/?d=retro&s=$size";
        return $link;
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
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

    /**
     * Returns all comments a user has
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Returns the playerTotal of this User if any.
     *
     * @return PlayerTotal
     */
    public function playerTotal()
    {
            return PlayerTotal::where('name','LIKE',"$this->player_totals_name")->first();
    }

    public function outbox()
    {
        return $this->hasMany('App\Mail','sender_id')->latest();
    }

    public function inbox()
    {
        return $this->hasMany('App\Mail','reciever_id')->latest();
    }

    public function unreadInbox()
    {
        return $this->hasMany('App\Mail','reciever_id')->where('seen_at',NULL)->latest();
    }

    public function sendmail($reciever,$subject,$body)
    {
        return $this->outbox()->create([
                'sender_id' => $this->id,
                'reciever_id' => $reciever->id,
                'subject' => $subject,
                'body' => $body
                ]);
    }

    /**
     * @return mixed
     */
    public function shouts()
    {
        return $this->hasMany('App\Shout');
    }

}
