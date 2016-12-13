<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class KTournament extends Model
{
    protected $fillable = [
        'name',
        'description',
        'rules',
        'photo_id',
        'bracket_type',
        'tournament_type',
        'minimum_participants',
        'maximum_participants',
        'rounds_per_match',
        'registration_starts_at',
        'registration_ends_at',
        'tournament_starts_at',
        'tournament_ends_at',
        'slug',
    ];

    protected $dates = ['registration_starts_at', 'registration_ends_at', 'tournament_starts_at', 'tournament_ends_at'];
    /**
     * Photo of the Tournament
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    /**
     * All Teams of this Tournament
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany('App\KTeam','k_tournament_id');
    }

    /**
     * All Matches of this Tournament
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matches()
    {
        return $this->hasMany('App\KMatch','k_tournament_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rounds()
    {
        return $this->hasMany('App\KRound','k_tournament_id');
    }

    /**
     * @return string
     */
    public function getHumanReadableType()
    {
        switch($this->tournament_type)
        {
            case 0:
                return "2v2 Team";
                break;
            case 1:
                return "1v1 Team";
                break;
            case 2:
                return "3v3 Team";
                break;
            default:
                return "2v2 Team";
        }
    }

    /**
     * @return string
     */
    public function getHumanReadableBType()
    {
        switch($this->bracket_type)
        {
            case 0:
                return "Round Robin";
            case 1:
                return "Double Elimination";
            default:
                return "Double Elimination";
        }
    }

    /**
     * Returns all comments of this T.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany('App\Comment','commentable');
    }

    /**
     * List of all managers excluding super admins.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function managers()
    {
        return $this->belongsToMany('App\User','k_tournament_managers')->withTimestamps();
    }

    /**
     * Return all players registered to this tournament.
     *
     * @return $this
     */
    public function players()
    {
        return $this->belongsToMany('App\User','k_tournament_user','k_tournament_id','user_id')->withTimestamps()->withPivot('user_status','k_team_id','total_score','id','user_position');
    }

    /**
     * Teams.
     *
     * @return $this
     */
    public function teamspivot()
    {
        return $this->belongsToMany('App\KTeam','k_tournament_user','k_tournament_id','k_team_id')->withTimestamps()->withPivot('user_status','user_id','total_score','id','user_position');
    }

    /**
     * Can user register
     *
     * @return bool
     */
    public function isRegistrationOpen()
    {
        // Tournament has ended
        if($this->disabled == false && $this->tournament_ends_at != null && $this->tournament_ends_at < Carbon::now())
        {
            return 6;
        }
        // Tournament has begun
        if($this->disabled == false && $this->tournament_starts_at < Carbon::now() && ($this->tournament_ends_at == null || $this->tournament_ends_at > Carbon::now()))
        {
            return 5;
        }
        //Register open
         if($this->disabled == false && $this->registration_starts_at < Carbon::now() && $this->registration_ends_at > Carbon::now())
         {
             return 1;
         }
         // Register time not begin.
        elseif($this->disabled == false && $this->registration_starts_at > Carbon::now())
        {
            return 2;
        }
         // Register time expires
        elseif($this->disabled == false && $this->registration_ends_at < Carbon::now())
        {
            return 3;
        }
         // Disabled
        elseif($this->disabled == true)
        {
            return 4;
        }
        else
        {
            return -1;
        }
    }

    /**
     * Approve and pending a team.
     *
     * @return bool
     */
    public function canAlterTeams()
    {
        if($this->isRegistrationOpen() == 1)
            return true;
        return false;
    }

    /**
     * Approve and pending a player
     *
     * @return bool
     */
    public function canAlterPlayersInTeam()
    {
        if($this->isRegistrationOpen() == 1 || $this->isRegistrationOpen() == 3)
            return true;
        return false;
    }


    /**
     * @return string
     */
    public function getHumanReadableStatus()
    {
        switch($this->isRegistrationOpen())
        {
            case 1:
                return "Registrations are <span class='text-green'>Open</span><br>";
                break;
            case 2:
                return "Registrations not <span class='text-info'>Started</span>";
                break;
            case 3:
                return "Registrations are <span class='text-danger'>Closed</span>";
                break;
            case 4:
                return "Tournament is <span class='text-danger'>Disabled</span>";
                break;
            case 5:
                if($this->minimum_participants > $this->teams()->qualified()->count())
                {
                    return "Tournament has <span class='text-green'>Delayed</span>";
                }
                return "Tournament has <span class='text-green'>Begun</span>";
                break;
            case 6:
                return "Tournament has <span class='text-warning'>Ended</span>";
                break;
            default:
                return "<span class='text-danger'>Unknown</span>";
                break;
        }
    }

    /**
     * @return bool
     */
    public function canShowBrackets()
    {
        if($this->isRegistrationOpen() == 3 || $this->isRegistrationOpen() == 5 || $this->isRegistrationOpen() == 6 && $this->teams()->qualified()->count() >= $this->minimum_participants)
        {
            if($this->minimum_participants > $this->teams()->qualified()->count())
            {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function canApplyToJoin()
    {
        if($this->isRegistrationOpen() == 1)
        {
            return true;
        }
        return false;
    }

    /**
     * @return int
     */
    public function maxPlayersPerTeam_Old()
    {
        switch($this->tournament_type)
        {
            case "2v2 Team":
                return 2;
                break;
            case "1v1 Solo":
                return 1;
                break;
            default:
                return 2;
        }
    }

    /**
     * @return int
     */
    public function maxPlayersPerTeam()
    {
        switch($this->tournament_type)
        {
            case 0:
                return 2;
                break;
            case 1:
                return 1;
                break;
            case 2:
                return 3;
                break;
            default:
                return 0;
        }
    }


    /**
     * @return bool
     */
    public function isFullParticipants()
    {
        if($this->teams()->where('team_status','1')->count() >= $this->maximum_participants)
        {
            return true;
        }
        return false;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDisabled($query)
    {
        return $query->where('disabled', true);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeEnabled($query)
    {
        return $query->where('disabled', false);
    }

    /**
     * Is all matches done
     *
     * @return bool
     */
    public function allMatchesDone()
    {
        foreach ($this->matches as $match) {
            if(!$match->has_been_played)
                return false;
        }
        return true;
    }

    /**
     * Is tourny Ended
     *
     * @return bool
     */
    public function isTournamentEnded()
    {
        return $this->isRegistrationOpen() == 6;
    }

    public function winnerteam()
    {
        return $this->belongsTo('App\KTeam','first_team_id','id');
    }

    public function secondteam()
    {
        return $this->belongsTo('App\KTeam','second_team_id','id');
    }

    public function thirdteam()
    {
        return $this->belongsTo('App\KTeam','third_team_id','id');
    }

}
