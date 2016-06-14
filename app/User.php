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
    protected $fillable = ['name', 'email', 'password','username','country_id','confirmation_token','last_ipaddress', 'dob', 'about', 'gender'];

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
    public function getGravatarLink($size=40)
    {
         //gravatar.com/avatar/{id}?d=mm&s=20
        $id = md5($this->email);
        $link = "//gravatar.com/avatar/$id/?d=monsterid&s=$size";
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

    /**
     * Messages Sent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany('App\Mail', 'sender_id', 'id');
    }

    /**
     * Messages Received
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receivedMessages()
    {
        return $this->hasMany('App\Mail', 'reciever_id', 'id');
    }

    /**
     * Returns all messages of this user sent by provided username
     *
     * @param $username
     * @return mixed
     */
    public function messagesBy($username)
    {
        $by = static::whereUsername($username)->firstOrFail();
        $messages = $this->receivedMessages()->where('sender_id',$by->id);
        return $messages;
    }


    /**
     * Returns all messages of this user sent by provided username and also Unseen
     *
     * @param $username
     * @return mixed
     */
    public function messagesUnseenBy($username)
    {
        $by = static::whereUsername($username)->firstOrFail();
        $messages = $this->receivedMessages()->where('sender_id',$by->id)->whereSeenAt(null);
        return $messages;
    }

    /**
     * All messages that are received and also not seen
     *
     * @return mixed
     */
    public function receivedMessagesUnseen()
    {
        return $this->receivedMessages()->whereSeenAt(null);
    }

    /**
     * Collection of all message either send or received by this user
     *
     * @return mixed
     */
    public function allMessages()
    {
        return Mail::where('sender_id',$this->id)->orWhere('receiver_id',$this->id);
    }


    /**
     * @return mixed
     */
    public function shouts()
    {
        return $this->hasMany('App\Shout');
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole(['admin','leader','superadmin']);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole(['leader','superadmin']);
    }

    /**
     * Function returns playertotal name or username which avail first.
     *
     * @return mixed
     */
    public function displayName()
    {
        $playerTotal = $this->playerTotal();
        if($playerTotal == NULL)
        {
            return $this->username;
        }
        else
        {
            return $playerTotal->name;
        }
    }

    /**
     * Returns all news of this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function news()
    {
        return $this->hasMany('App\News');
    }

}
