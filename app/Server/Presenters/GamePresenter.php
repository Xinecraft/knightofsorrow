<?php
/**
 *
 * Copyright (c) 2014 Zishan Ansari
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * Date: 7/25/2015
 * Time: 2:24 AM
 */

namespace App\Server\Presenters;

use App\Game;
use McCool\LaravelAutoPresenter\BasePresenter;

class GamePresenter extends BasePresenter
{
    /**
     * Construct the Model
     *
     * @param Game $resource
     */
    public function __construct(Game $resource)
    {
        $this->wrappedObject = $resource;
    }

    public function mapName()
    {
        return \App\Server\Utils::getMapTitleById($this->wrappedObject->map_id);
    }

    public function timeAgo()
    {
        return $this->wrappedObject->created_at->diffForHumans();
    }

    public function timeDDTS()
    {
        return $this->wrappedObject->created_at->toDayDateTimeString();
    }

    public function time($format="%dm %ds")
    {
        return \App\Server\Utils::getMSbyS($this->wrappedObject->round_time,$format);
    }

    public function swatScoreWithColor()
    {
        if($this->wrappedObject->swat_score > $this->wrappedObject->suspects_score)
        {
            return "<font color='#32cd32'><b>".$this->wrappedObject->swat_score."</b></font>";
        }
        elseif($this->wrappedObject->swat_score < $this->wrappedObject->suspects_score)
        {
            return "<font color='#C60D00'><b>".$this->wrappedObject->swat_score."</b></font>";
        }
        else
        {
            return $this->wrappedObject->swat_score;
        }
    }

    public function suspectsScoreWithColor()
    {
        if($this->wrappedObject->swat_score > $this->wrappedObject->suspects_score)
        {
            return "<font color='#C60D00'><b>".$this->wrappedObject->suspects_score."</b></font>";
        }
        elseif($this->wrappedObject->swat_score < $this->wrappedObject->suspects_score)
        {
            return "<font color='#32cd32'><b>".$this->wrappedObject->suspects_score."</b></font>";
        }
        else
        {
            return $this->wrappedObject->suspects_score;
        }
    }

    public function topScorer()
    {

        return $this->wrappedObject->players()->orderBy('score','DESC')->first();
    }

    public function massArrester()
    {

        return $this->wrappedObject->players()->orderBy('arrests','DESC')->first();
    }

    public function killingMachine()
    {

        return $this->wrappedObject->players()->orderBy('kills','DESC')->first();
    }

    public function bestKillStreak()
    {

        return $this->wrappedObject->players()->orderBy('kill_streak','DESC')->first();
    }

    public function bestArrestStreak()
    {

        return $this->wrappedObject->players()->orderBy('arrest_streak','DESC')->first();
    }

    public function bestDeathStreak()
    {

        return $this->wrappedObject->players()->orderBy('death_streak','DESC')->first();
    }

    public function bestScorePerMin()
    {
        return $this->wrappedObject->players()->select(DB::raw('*,score/time_played as scoremin'))->orderBy('scoremin','DESC')->first();
    }

    public function SwatPlayers()
    {
        return $this->wrappedObject->players()->where('team',0)->orderBy('score','DESC')->groupBy('name')->get();
    }

    public function SuspectPlayers()
    {
        return $this->wrappedObject->players()->where('team',1)->orderBy('score','DESC')->groupBy('name')->get();
    }

}