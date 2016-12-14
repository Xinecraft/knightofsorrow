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
use Carbon\Carbon;
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

        return "<b><a href=".route('player-detail',[htmlentities($playerTotal->name)]).">".htmlentities($playerTotal->name)."</a></b>";
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

    /**
     * <img class="tooltipster" title="{{ $player->rank->name }}" src="{{ $player->rankImage }}" alt="" height="22px"/>
     */
    public function linkPlayerRank()
    {
        $playerTotal = $this->wrappedObject->PlayerTotal();
        if($playerTotal == null || empty($playerTotal) || $playerTotal == "")
            return "";

        return "<img class='tooltipster' title='".$playerTotal->rank->name."' src='".url('/images/game/insignia/')."/{$playerTotal->rank->id}".".png' alt='' height='22px'/>";
    }

    public function age()
    {
        $age = $this->wrappedObject->dob;
        if($age == null)
            return "<i class='small'>Not Specified</i>";

        $age = $age->age;
        $ages = str_plural("year", $age);
        return "<b class='tooltipster' title='".$this->wrappedObject->dob->format('F jS, Y')."'>$age $ages old</b>";
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

    public function roleImageLink()
    {
        try
        {
            $role = $this->wrappedObject->roles()->first()->name;
            $r = $role;
        }
        catch(\Exception $e)
        {
            $r = "guest";
        }

        return url('/images/user_ranks')."/".$r.".png";

    }

    public function joinedOn()
    {
        return $this->wrappedObject->created_at->diffForHumans();
    }

    public function lastSeenOn()
    {
        if($this->isOnline())
            return "<span class='text-green'>&#x25cf; Online &#x25cf;</span>";
        return $this->wrappedObject->updated_at->diffForHumans();
    }

    public function isOnline()
    {
        return Carbon::now()->timestamp - $this->wrappedObject->updated_at->timestamp <= 180; //3 mins
    }

    public function dname()
    {
        return $this->wrappedObject->displayName();
    }

    public function followersAsTitle()
    {
        $data = "";
        //title="&lt;div class='text-center text-bold' &gt; {{ $rank->name }} &lt;/div&gt; &lt;br&gt;Points: {{ $rank->description }}
        foreach($this->wrappedObject->followers()->get() as $follower)
        {
            $data .= $follower->displayName()."<br>";
        }
        return $data;
    }

    public function followingsAsTitle()
    {
        $data = "";
        //title="&lt;div class='text-center text-bold' &gt; {{ $rank->name }} &lt;/div&gt; &lt;br&gt;Points: {{ $rank->description }}
        foreach($this->wrappedObject->following()->get() as $following)
        {
            $data .= $following->displayName()."<br>";
        }
        return $data;
    }

    public function evolveId()
    {
        if($this->wrappedObject->evolve_id == null || $this->wrappedObject->evolve_id == "")
        {
            return "<i class='small'>Unknown</i>";
        }
        return "<b>".htmlentities($this->wrappedObject->evolve_id)."</b>";
    }

    public function steamId()
    {
        if($this->wrappedObject->steam_nickname == null || $this->wrappedObject->steam_nickname == "")
        {
            return "<i class='small'>Unknown</i>";
        }
        return "<b>".htmlentities($this->wrappedObject->steam_nickname)."</b>";
    }

    public function discordUsername()
    {
        if($this->wrappedObject->discord_username == null || $this->wrappedObject->discord_username == "")
        {
            return "<i class='small'>Unknown</i>";
        }
        return "<b>".htmlentities($this->wrappedObject->discord_username)."</b>";
    }

    public function grId()
    {
        if($this->wrappedObject->gr_id == null || $this->wrappedObject->gr_id == "")
        {
            return "<i class='small'>Unknown</i>";
        }
        return "<b>".htmlentities($this->wrappedObject->gr_id)."</b>";
    }

    public function fbURL()
    {
        if($this->wrappedObject->facebook_url == null || $this->wrappedObject->facebook_url == "")
        {
            return "<i class='small'>Unknown</i>";
        }
        return "<b>".link_to($this->wrappedObject->facebook_url,"Click here", ['target' => '_blank'])."</b>";
    }

    public function websiteURL()
    {
        if($this->wrappedObject->website_url == null || $this->wrappedObject->website_url == "")
        {
            return "<i class='small'>Unknown</i>";
        }
        return "<b>".link_to($this->wrappedObject->website_url,"Click here", ['target' => '_blank'])."</b>";
    }

    public function ranking()
    {
        return 0;
    }

    public function rating()
    {
        return 0.0;
    }

    public function dob()
    {
        if($this->wrappedObject->dob != NULL)
            return $this->wrappedObject->dob->toDateString();
    }

}
