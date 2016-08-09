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
    ];

    protected $dates = ['starts_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tournament()
    {
        return $this->belongsTo('App\KTournament');
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
}
