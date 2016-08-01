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

use App\PlayerTotal;
use McCool\LaravelAutoPresenter\BasePresenter;

class PlayerTotalPresenter extends BasePresenter
{
    /**
     * Construct the Model
     *
     * @param PlayerTotal $resource
     */
    public function __construct(PlayerTotal $resource)
    {
        $this->wrappedObject = $resource;
    }

    public function countryImage()
    {
        return "/images/flags/20_shiny/".$this->wrappedObject->country->countryCode.".png";
    }

    public function countryName()
    {
        return $this->wrappedObject->country->countryName;
    }

    public function rankImage()
    {
        return "/images/game/insignia/".$this->wrappedObject->rank->id.".png";
    }

    public function rankName()
    {
        return $this->wrappedObject->rank->name;
    }

    public function timePlayed($format = "%dh %dm")
    {
        return \App\Server\Utils::getHMbyS($this->wrappedObject->total_time_played,$format);
    }

    public function playerRating()
    {
        if($this->wrappedObject->player_rating != null)
            return $this->wrappedObject->player_rating;
        else
            return "<span class='text-muted'>None</span>";
    }

    public function loadoutPw()
    {
        return \App\Server\Utils::getEquipmentTitleById($this->wrappedObject->loadout->primary_weapon);
    }

    public function loadoutPa()
    {
        return \App\Server\Utils::getAmmoTitleById($this->wrappedObject->loadout->primary_ammo);
    }

    public function loadoutSw()
    {
        return \App\Server\Utils::getEquipmentTitleById($this->wrappedObject->loadout->secondary_weapon);
    }

    public function loadoutSa()
    {
        return \App\Server\Utils::getAmmoTitleById($this->wrappedObject->loadout->secondary_ammo);
    }

    public function loadoutEq1()
    {
        return \App\Server\Utils::getEquipmentTitleById($this->wrappedObject->loadout->equip_one);
    }

    public function loadoutEq2()
    {
        return \App\Server\Utils::getEquipmentTitleById($this->wrappedObject->loadout->equip_two);
    }

    public function loadoutEq3()
    {
        return \App\Server\Utils::getEquipmentTitleById($this->wrappedObject->loadout->equip_three);
    }

    public function loadoutEq4()
    {
        return \App\Server\Utils::getEquipmentTitleById($this->wrappedObject->loadout->equip_four);
    }

    public function loadoutEq5()
    {
        return \App\Server\Utils::getEquipmentTitleById($this->wrappedObject->loadout->equip_five);
    }

    public function loadoutBr()
    {
        return \App\Server\Utils::getEquipmentTitleById($this->wrappedObject->loadout->breacher);
    }

    public function loadoutHead()
    {
        return \App\Server\Utils::getEquipmentTitleById($this->wrappedObject->loadout->head);
    }

    public function loadoutBody()
    {
        return \App\Server\Utils::getEquipmentTitleById($this->wrappedObject->loadout->body);
    }

    public function scorePerRound()
    {
        return round($this->wrappedObject->total_score/$this->wrappedObject->total_round_played,2);
    }

    public function winLostRatio()
    {
        $ratio = $this->wrappedObject->game_lost == 0 ? $this->wrappedObject->game_won : round($this->wrappedObject->game_won/$this->wrappedObject->game_lost,2);
        return $ratio;
    }

    public function weaponAccuracy()
    {
        $weapons = ($this->wrappedObject->alias->weapons);
        $sh = $weapons->sum('shots_hit');
        $sf = $weapons->sum('shots_fired');
        $accuracy = round( $sf == 0 ? 0 : $sh / $sf * 100 , 2);
        return $accuracy;
    }

    public function totalAmmoFired()
    {
        $weapons = ($this->wrappedObject->alias->weapons);
        $sf = $weapons->sum('shots_fired');
        return $sf;
    }

    public function longestKillDistance()
    {
        $weapons = ($this->wrappedObject->alias->weapons);
        $lk = $weapons->max('distance');
        return $lk;
    }


    /**
     * @return string
     */
    public function owner()
    {
        $owner = $this->wrappedObject->user();
        if($owner == null)
            return "<i class='text-muted'>None</i>";
        else
            return link_to_route('user.show',"@".$owner->username,[$owner->username]);
    }

    public function ownerWithPicture()
    {
        //return "aaa";
        $owner = $this->wrappedObject->user();
        if($owner == null)
            return "";
        else
            return "<a href='".route('user.show',$owner->username)."'><img title='{$owner->username}' class='tooltipster col-md-offset-1 col-sm-offset-1 col-xs-offset-1 img-thumbnail' width='60px' style='width: 60px' src='{$owner->getGravatarLink(60)}'></a>";
            //return link_to_route('user.show',"@".$owner->username,[$owner->username]);
    }

    public function nameTrimmed()
    {
        return str_limit($this->wrappedObject->name,15);
    }
}