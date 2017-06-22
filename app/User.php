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
    protected $fillable = ['name', 'email','photo_id', 'password','username','country_id','confirmation_token','last_ipaddress', 'dob', 'about', 'gender', 'gr_id', 'evolve_id', 'facebook_url', 'website_url', 'steam_nickname', 'email_notifications_new_message', 'discord_username', 'back_img_url', 'koin', 'muted'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token','confirmation_token'];

    protected $dates = ['dob'];

    protected $with = ['roles'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function iphistory()
    {
        return $this->hasMany('App\Iphistory')->latest();
    }

    /**
     * Returns gravatar ID
     */
    public function getGravatarLink($size=40)
    {
        if($this->photo_id == null || $this->photo_id == "")
        {
            if($this->gender == "Male")
                return route('make.thumbnail',["Male.jpg",$size]);
            elseif($this->gender == "Female")
                return route('make.thumbnail',["Female.jpg",$size]);
            else
                return route('make.thumbnail',["vip.jpg",$size]);
        }
        else
        {
            return route('make.thumbnail',[$this->photo->url,$size]);
        }
        /*
        $email = $this->email;
        $email = trim($email);
        $email = strtolower($email);
        $id = md5($email);
        $link = "//gravatar.com/avatar/$id/?d=monsterid&s=$size";
        return $link;
        */
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

    public function isSubAdmin()
    {
        return $this->hasRole(['elder','admin','leader','superadmin']);
    }

    /**
     * Function returns playertotal name or username which avail first.
     *
     * @return mixed
     */
    public function displayName()
    {
        if($this->player_totals_name == "" || $this->player_totals_name == NULL)
        {
            return $this->username;
        }
        else
        {
            return $this->player_totals_name;
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function didyouknows()
    {
        return $this->hasMany('App\Didyouknow');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pollqs()
    {
        return $this->hasMany('App\Pollq');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pollos()
    {
        return $this->belongsToMany('App\Pollo')->withTimestamps();
    }


    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    /**
     * @return Notification
     */
    public function newNotification()
    {
        $notification = new Notification;
        $notification->user()->associate($this);

        return $notification;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdtournaments()
    {
        return $this->hasMany('App\KTournament');
    }

    /**
     * List of tournament this user is manager or referee of.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function managingtournaments()
    {
        return $this->belongsToMany('App\KTournament','k_tournament_managers');
    }

    /**
     * All teams that this user created
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdteams()
    {
        return $this->hasMany('App\KTeam');
    }

    /**
     * Return all tournaments this user applied for.
     *
     * @return $this
     */
    public function appliedtournaments()
    {
        return $this->belongsToMany('App\KTournament','k_tournament_user','user_id','k_tournament_id')->withTimestamps()->withPivot('user_status','k_team_id','total_score','id','user_position');
    }

    /**
     * Get applied status
     *
     * @param $tournament
     * @param $team
     * @return mixed
     */
    public function getAppliedTeamStatus($tournament,$team)
    {
        return $this->appliedtournaments()->where('k_team_id',$team->id)->where('k_tournament_id',$tournament->id)->first()->pivot->user_status;
    }

    public function getAppliedTeamStatusWithColor($tournament,$team)
    {
        switch($this->getAppliedTeamStatus($tournament,$team))
        {
            case 0:
                return "<span class='text-warning'>Pending Approval</span>";
                break;
            case 1:
                return "<span class='text-danger'>Not Eligible</span>";
                break;
            case 2:
                return "<span class='text-danger'>Disqualified</span>";
                break;
            case 3:
                return "<span class='text-green'>Team Member</span>";
                break;
            case 4:
                return "<span class='text-success'>Team Leader</span>";
                break;
            default:
                return "<span class='text-info'>Unknown</span>";
                break;
        }
    }

    public function getTeamOfUserForTournament($tournament)
    {
        $team = $tournament->teamspivot()->wherePivot('user_id',$this->id)->first();

        if($team)
        {
            return $team;
        }
        else
        {
            return null;
        }
    }

    public function isAppliedForTournament($tournament)
    {
        $team = $this->getTeamOfUserForTournament($tournament);
        if($team)
            return true;
        else
            return false;
    }

    /**
     * @param KTeam $team
     * @return bool
     */
    public function canHandleTeam(KTeam $team)
    {
        $user = \Auth::user();

        if($team->tournament->isRegistrationOpen() == 6 || $team->tournament->isRegistrationOpen() == 5)
        {
            return false;
        }

        /**
         * If Manager
         */
        if($user->canManageTournament($team->tournament))
            return true;

        // Donot allow if team is not approved
        if(!$team->isApproved())
        {
            return false;
        }

        if($team->playerspivot()->where('user_id',$user->id)->where('user_status','>',3)->first())
        {
            return true;
        }
        return false;
    }

    /**
     * Is this user authenticated to manage tournament
     *
     * @param KTournament $tour
     * @return bool
     */
    public function canManageTournament(KTournament $tour)
    {
        if(\Auth::user()->isSuperAdmin())
            return true;

        foreach ($this->managingtournaments as $tournament) {
            if ($tournament->id == $tour->id) {
                return true;
            }
        }
        return false;
    }

    /**********************************************************
     * CLANS FUNCTIONS
     **********************************************************
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clans()
    {
        return $this->hasMany('App\Clan','submitter_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deletedPlayers()
    {
        return $this->hasMany('App\DeletedPlayer','admin_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdPlayerPoints()
    {
        return $this->hasMany('App\PlayerPoint', 'admin_id', 'id');
    }

    /**
     * List of all trophy created by this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createTrophy()
    {
        return $this->hasMany('App\Trophy');
    }

    /**
     * All won trophies he have.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function trohpies()
    {
        return $this->belongsToMany('App\Trophy')->withTimestamps();
    }

    /**
     * The clan roles that belong to the user.
     */
    public function clanroles()
    {
        return $this->belongsToMany('App\Clanrole');
    }
}
