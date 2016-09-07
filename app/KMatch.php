<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KMatch extends Model
{
    protected $fillable = [
        'k_tournament_id',
        'game1_id',
        'game2_id',
        'game3_id',
        'game4_id',
        'game5_id',
        'k_team1_id',
        'k_team2_id',
        'k_team1_total_score',
        'k_team2_total_score',
        'winner_team_id',
        'starts_at',
        'team1_from_match_rank',
        'team1_from_match_index',
        'team2_from_match_rank',
        'team2_from_match_index',
        'match_index'
    ];

    protected $dates = ['starts_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tournament()
    {
        return $this->belongsTo('App\KTournament','k_tournament_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game1()
    {
        return $this->belongsTo('App\Game','game1_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game2()
    {
        return $this->belongsTo('App\Game','game2_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game3()
    {
        return $this->belongsTo('App\Game','game3_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game4()
    {
        return $this->belongsTo('App\Game','game4_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game5()
    {
        return $this->belongsTo('App\Game','game5_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game6()
    {
        return $this->belongsTo('App\Game','game6_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team1()
    {
        return $this->belongsTo('App\KTeam','k_team1_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team2()
    {
        return $this->belongsTo('App\KTeam','k_team2_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function winner()
    {
        return $this->belongsTo('App\KTeam','winner_team_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function round()
    {
        return $this->belongsTo('App\KRound','k_round_id');
    }

    /**
     * @return string
     */
   public function getWinningTextForHumans()
   {
       if($this->winner_team_id == -1)
       {
           return "<i class='text-danger text-bold'>Match Cancelled</i>";
       }
       else if($this->winner_team_id == 0)
       {
           return "<span class=''>Match tied by <b>{$this->winner_team_won_by}</b></span>";
       }
       else if($this->team1->id == $this->winner_team_id)
       {
           $winner = $this->team1;
           $loser = $this->team2;
           return "<span class=''><span class='text-bold text-green'>".link_to_route('tournament.team.show',$winner->name,[$this->tournament->slug,$winner->id],['class' => 'aingreen text-green'])."</span> beats <span class='text-bold text-danger'>".link_to_route('tournament.team.show',$loser->name,[$this->tournament->slug,$loser->id])."</span> by <br><b>{$this->k_team1_total_score} - {$this->k_team2_total_score}</b></span>";
       }
       else if($this->team2->id == $this->winner_team_id)
       {
           $winner = $this->team2;
           $loser = $this->team1;
           return "<span class=''><span class='text-bold text-green'>".link_to_route('tournament.team.show',$winner->name,[$this->tournament->slug,$winner->id],['class' => 'aingreen text-green'])."</span> beats <span class='text-bold text-danger'>".link_to_route('tournament.team.show',$loser->name,[$this->tournament->slug,$loser->id])."</span> by <br><b>{$this->k_team2_total_score} - {$this->k_team1_total_score}</b></span>";
       }
   }

    /**
     * @return string
     */
    public function getWinningTextForNotifications()
    {
        if($this->winner_team_id == -1)
        {
            return "<i class='text-danger text-bold'>Match Cancelled</i>";
        }
        else if($this->winner_team_id == 0)
        {
            return "<span class=''>Match tied by <b>{$this->winner_team_won_by}</b></span>";
        }
        else if($this->team1->id == $this->winner_team_id)
        {
            $winner = $this->team1;
            $loser = $this->team2;
            return "<span class=''><span class='text-bold text-green'>".link_to_route('tournament.team.show',$winner->name,[$this->tournament->slug,$winner->id],['class' => 'aingreen text-green'])."</span> beats <span class='text-bold text-danger'>".link_to_route('tournament.team.show',$loser->name,[$this->tournament->slug,$loser->id])."</span> by <b>{$this->k_team1_total_score} - {$this->k_team2_total_score}</b></span>";
        }
        else if($this->team2->id == $this->winner_team_id)
        {
            $winner = $this->team2;
            $loser = $this->team1;
            return "<span class=''><span class='text-bold text-green'>".link_to_route('tournament.team.show',$winner->name,[$this->tournament->slug,$winner->id],['class' => 'aingreen text-green'])."</span> beats <span class='text-bold text-danger'>".link_to_route('tournament.team.show',$loser->name,[$this->tournament->slug,$loser->id])."</span> by <b>{$this->k_team2_total_score} - {$this->k_team1_total_score}</b></span>";
        }
    }
}
