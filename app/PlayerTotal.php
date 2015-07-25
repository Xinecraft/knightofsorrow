<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;
use App\Server\Presenters\PlayerTotalPresenter;

class PlayerTotal extends Model implements HasPresenter
{
    /**
     * @return PlayerTotalPresenter
     */
    public function getPresenterClass()
    {
        return PlayerTotalPresenter::class;
    }

    /**
     * Returns the Alias instance of the current Player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alias()
    {
        return $this->belongsTo('App\Alias');
    }

    /**
     * Returns the Profile instance of the current Player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    /**
     * Returns Country instance to which this Player belongs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * Returns the Rank of this Player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rank()
    {
        return $this->belongsTo('App\Rank');
    }

    /**
     * Returns the last Valid loadout of the Player.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function loadout()
    {
        return $this->belongsTo('App\Loadout','last_loadout_id');
    }

    /**
     * Returns the first Game played by this Player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function firstGame()
    {
        return $this->belongsTo('App\Game','first_game_id');
    }

    /**
     * Returns the last Game played by this Player
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastGame()
    {
        return $this->belongsTo('App\Game','last_game_id');
    }




}
