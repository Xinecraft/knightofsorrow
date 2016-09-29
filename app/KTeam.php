<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KTeam extends Model
{
    protected $fillable = [
        'name',
        'description',
        'photo_id',
        'k_tournament_id',
        'k_group_id',
        'clan_id',
        'country_id',
        'team_position',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tournament()
    {
        return $this->belongsTo('App\KTournament','k_tournament_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clan()
    {
        return $this->belongsTo('App\Clan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    /**
     * Team creator
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeQualified($query)
    {
        return $query->where('team_status', '=', 1);
    }

    /**
     * Tournaments.
     *
     * @return $this
     */
    public function tournamentspivot()
    {
        return $this->belongsToMany('App\KTournament','k_tournament_user','k_team_id','k_tournament_id')->withTimestamps()->withPivot('user_status','user_id','total_score','id','user_position');
    }

    /**
     * All Players on this team either selected or not
     *
     * @return $this
     */
    public function playerspivot()
    {
        return $this->belongsToMany('App\User','k_tournament_user','k_team_id','user_id')->withTimestamps()->withPivot('user_status','k_tournament_id','total_score','id','user_position');
    }

    /**
     * All Players on the team selected
     *
     * @return $this
     */
    public function playerselected()
    {
        return $this->playerspivot()->wherePivot('user_status','>=','3');
    }

    /**
     * Pending Players
     *
     * @return mixed
     */
    public function playerpending()
    {
        return $this->playerspivot()->wherePivot('user_status','<','3');
    }

    public function addplayertoteam($user,$tournament,$role=0)
    {
        // If team is full
        if($this->isFull())
            return false;
        // If team is disqualified
        if($this->team_status == 2)
            return false;
        // If this team is not in current tournament
        if($tournament->id != $this->k_tournament_id)
            return false;
        //if user already registered
        if($this->tournamentspivot()->wherePivot('user_id',$user->id)->first())
        {
            return false;
        }
        $add = $this->tournamentspivot()->attach($tournament->id,['user_id' => $user->id,'user_status' => $role]);
        return $add;
    }

    /**
     * Remove user from tournament and team.
     *
     * @param $user
     * @return bool
     */
    public function removeplayerfromteam($user)
    {
        //only if user already registered
        if($this->tournamentspivot()->wherePivot('user_id',$user->id)->first())
        {
            $tournament = $this->tournamentspivot()->wherePivot('user_id',$user->id)->first()->id;
            //dd($pid);
            $this->tournamentspivot()->wherePivot('user_id',$user->id)->detach($tournament);
            return true;
        }
        return false;
    }

    /**
     * Make player pending from tournament and team.
     *
     * @param $user
     * @return bool
     */
    public function makeplayerpendingfromteam($user)
    {
        //only if user already registered
        if($this->tournamentspivot()->wherePivot('user_id',$user->id)->first())
        {
            $player_rank = $this->tournamentspivot()->wherePivot('user_id',$user->id)->first()->pivot->user_status;

            // If is a admin of team (team leader) || already in pending list.
            if($player_rank > 3 || $player_rank == 0)
                return false;

            $tournament = $this->tournamentspivot()->wherePivot('user_id',$user->id)->first();
            $tournament->pivot->where('user_id',$user->id)->where('k_team_id',$this->id)->update(['user_status' => 0]);
            //$tournament->save();
            return true;
        }
        return false;
    }


    /**
     * Approve user to tournament and team.
     *
     * @param $user
     * @return bool
     */
    public function approveplayertoteam($user)
    {
        //only if user already registered
        if($this->tournamentspivot()->wherePivot('user_id',$user->id)->first())
        {
            $player_rank = $this->tournamentspivot()->wherePivot('user_id',$user->id)->first()->pivot->user_status;

            // If a Disqualified or already Member or Leader
            // @Note Not eligible status can be changed
            if($player_rank == 2 || $player_rank == 3 || $player_rank == 4)
                return false;

            $tournament = $this->tournamentspivot()->wherePivot('user_id',$user->id)->first();
            $tournament->pivot->where('user_id',$user->id)->where('k_team_id',$this->id)->update(['user_status' => 3]);
            //$tournament->save();
            return true;
        }
        return false;
    }

    /**
     * Approve user to tournament and team.
     *
     * @param $user
     * @return bool
     */
    public function givescoretouser($user,$score)
    {
        //only if user already registered
        if($this->tournamentspivot()->wherePivot('user_id',$user->id)->first())
        {
            $player_rank = $this->tournamentspivot()->wherePivot('user_id',$user->id)->first()->pivot->user_status;

            if($player_rank == 2 || $player_rank == 1)
                return false;

            $tournament = $this->tournamentspivot()->wherePivot('user_id',$user->id)->first();
            $old_score = $tournament->pivot->total_score;
            $new_score = $old_score + $score;
            $tournament->pivot->where('user_id',$user->id)->where('k_team_id',$this->id)->update(['total_score' => $new_score]);
            //$tournament->save();
            return true;
        }
        return false;
    }

    /**
     * Return if team is full or not
     *
     * @return bool
     */
    public function isFull()
    {
        if($this->playerselected()->count() >= $this->tournament->maxPlayersPerTeam())
        {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        return $this->teamclosed;
    }

    public function getColorStatus()
    {
        if($this->isClosed())
            return "<b class='text-danger'>Closed</b>";
        else
            return "<b class='text-green'>Open</b>";
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        if($this->team_status == 1)
            return true;
        return false;
    }

    /**
     * @return string
     */
    public function getColorAppr()
    {
        switch($this->team_status)
        {
            case 0:
                return "<span class='text-warning'>Pending Approval</span>";
                break;
            case 1:
                return "<span class='text-green'>Qualified</span>";
                break;
            case 2:
                return "<span class='text-danger'>Disqualified</span>";
                break;
            case 3:
                return "<span class='text-danger'>Not Eligible</span>";
                break;
            default:
                return "<span class='text-warning'>Pending</span>";
                break;
        }
    }

    /**
     * @return string
     */
    public function getColorAppr2()
    {
        switch($this->team_status)
        {
            case 0:
                return "<span class='text-warning text-bold'>Pending Approval</span> from a Manager";
                break;
            case 1:
                return "<span class='text-green text-bold'>Qualified</span> for tournament";
                break;
            case 2:
                return "<span class='text-danger text-bold'>Disqualified</span> from tournament";
                break;
            case 3:
                return "<span class='text-danger text-bold'>Not Eligible</span> for tournament";
                break;
            default:
                return "<span class='text-warning text-bold'>Pending</span>";
                break;
        }
    }

    public function getRankingAttribute()
    {
        return 0;
    }

    public function getTourplayedAttribute()
    {
        return 1;
    }

}
