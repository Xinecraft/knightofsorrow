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

use App\User;
use McCool\LaravelAutoPresenter\BasePresenter;

class UserPresenter extends BasePresenter
{
    /**
    * Construct the Model
    *
    * @param User $resource
    */
    public function __construct(User $resource)
    {
        $this->wrappedObject = $resource;
    }

    public function linkPlayerNamewithLink()
    {
        $playerTotal = $this->wrappedObject->PlayerTotal();
        if($playerTotal == null || empty($playerTotal) || $playerTotal == "")
        {
            if(\Auth::check() && \Auth::user()->id == $this->wrappedObject->id)
                return "<i><b class='small'>".link_to_route('user.setting',"Choose one")."</b></i>";
            else
                return "<i class='small'>Unknown</i>";
        }

        return "<b><a href=".route('player-detail',[$playerTotal->id,htmlentities($playerTotal->name)]).">".htmlentities($playerTotal->name)."</a></b>";
    }

    public function linkPlayerPosition()
    {
        $playerTotal = $this->wrappedObject->PlayerTotal();
        if($playerTotal == null || empty($playerTotal) || $playerTotal == "")
            return "<i class='small'>Unknown</i>";

        return "<b class='text-success'>$playerTotal->position</b> out of ".\App\PlayerTotal::count();
    }

    public function linkPlayerTimePlayed()
    {
        $playerTotal = $this->wrappedObject->PlayerTotal();
        if($playerTotal == null || empty($playerTotal) || $playerTotal == "")
            return "<i class='small'>Unknown</i>";

        return "<b>".\App\Server\Utils::getHMbyS($playerTotal->total_time_played,"%dh %dm")."</b>";
    }

    public function linkPlayerLastSeen()
    {
        $playerTotal = $this->wrappedObject->PlayerTotal();
        if($playerTotal == null || empty($playerTotal) || $playerTotal == "")
            return "<i class='small'>Unknown</i>";

        return "<b>".link_to_route('round-detail',$playerTotal->lastGame->created_at->diffForHumans(),[$playerTotal->last_game_id])."</b>";
    }

    public function age()
    {
        $age = $this->wrappedObject->dob;
        if($age == null)
            return "<i class='small'>Not Specified</i>";

        $age = $age->age;
        $ages = str_plural("year", $age);
        return "<b>$age $ages old</b>";
    }

    public function role()
    {
        try
        {
            $role = $this->wrappedObject->roles()->first()->display_name;
            return $role;
        }
        catch(\Exception $e)
        {
            return "Member";
        }
    }

    public function joinedOn()
    {
        return $this->wrappedObject->created_at->diffForHumans();
    }

    public function lastSeenOn()
    {
        return $this->wrappedObject->updated_at->diffForHumans();
    }

}