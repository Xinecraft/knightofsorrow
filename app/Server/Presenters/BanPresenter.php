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

use App\Ban;
use App\PlayerTotal;
use McCool\LaravelAutoPresenter\BasePresenter;

class BanPresenter extends BasePresenter
{
    /**
     * Construct the Model
     *
     * @param Ban $resource
     */
    public function __construct(Ban $resource)
    {
        $this->wrappedObject = $resource;
    }

    public function statusWithColor()
    {
        if($this->wrappedObject->status)
        {
            return "<span class='text-danger'>Banned</span>";
        }
        else
        {
            return "<span class='text-green'>Unbanned</span>";
        }
    }

    public function ipAddrWithMask()
    {
        if(\Auth::check() && \Auth::user()->isAdmin())
        {
            return $this->wrappedObject->ip_address;
        }

        $ip = $this->wrappedObject->ip_address;
        $ip = explode('.',$ip);

        return $ip[0].".".$ip[1].".xx.xx";
    }

    public function bannedByAdminURL()
    {
        $admin = $this->wrappedObject->admin_name;

        // If created at site then admin contains username and get user from username and display name.
        if($this->wrappedObject->created_by_site)
        {
            $user = \App\User::whereUsername($admin)->first();

            if($user)
                return link_to_route('user.show',$user->displayName(),[$user->username],['class' => 'ainorange']);
        }

        if(str_contains($admin," (WebAdmin)"))
        {
            $webadmin = explode(" ",$admin);
            $admin = $webadmin[0];
        }


        $pt = PlayerTotal::findOrFailByNameWithNull($admin);

        // If Player total found
        if($pt)
        {
            $name = htmlentities($pt->name);

            // If PT has user linked
            if($ptu = $pt->user())
            {
                return link_to_route('user.show',$name,[$ptu->username],['class' => 'ainorange']);
            }
            return link_to_route('player-detail',$name,$name,['class' => 'ainorange']);
        }
        // Admin Not found
        else
        {
            return $admin;
        }
    }

    public function updatedByAdminURL()
    {
        $admin = $this->wrappedObject->updated_by;

        // If updated from website then use username to get display name.
        if($this->wrappedObject->updated_by_site)
        {
            $user = \App\User::whereUsername($admin)->first();

            if($user)
                return link_to_route('user.show',$user->displayName(),[$user->username],['class' => 'ainorange']);
        }

        if(str_contains($admin," (WebAdmin)"))
        {
            $webadmin = explode(" ",$admin);
            $admin = $webadmin[0];
        }

        $pt = PlayerTotal::findOrFailByNameWithNull($admin);

        // If Player total found
        if($pt)
        {
            $name = htmlentities($pt->name);

            // If PT has user linked
            if($ptu = $pt->user())
            {
                return link_to_route('user.show',$name,[$ptu->username],['class' => 'ainorange']);
            }
            return link_to_route('player-detail',$name,$name,['class' => 'ainorange']);
        }
        // Admin Not found
        else
        {
            return $admin;
        }
    }

    public function bannedUserURL()
    {
        $name = $this->wrappedObject->name;

        if($name == "~ManualIPBan")
        {
            return "<i>~ManualIPBan</i>";
        }

        $pt = PlayerTotal::findOrFailByNameWithNull($name);

        if($pt)
        {
            $name = htmlentities($pt->name);

            // If PT has user linked
            if($ptu = $pt->user())
            {
                return link_to_route('user.show',$name,[$ptu->username],['class' => 'ainorange']);
            }
            return link_to_route('player-detail',$name,$name,['class' => 'ainorange']);
        }
        // Admin Not found
        else
        {
            return $name;
        }
    }

    /**
     * @return string
     */
    public function countryImage()
    {
        return "/images/flags/20_shiny/".$this->wrappedObject->country->countryCode.".png";
    }

    /**
     * @return mixed
     */
    public function countryName()
    {
        $name = $this->wrappedObject->country->countryName;

        if(str_contains($name,", "))
        {
            $name = explode(", ",$name);
            return $name[1]." ".$name[0];
        }
        return $name;
    }

    public function reason()
    {
        return $this->wrappedObject->reason == null || $this->wrappedObject->reason == "" ? "-" : $this->wrappedObject->reason;
    }

    public function bannedTill()
    {
        if($this->wrappedObject->banned_till)
        {
            return $this->wrappedObject->banned_till->diffForHumans();
        }
        else
        {
            return "Permanent Ban";
        }
    }

    public function bannedTillDateTime()
    {
        if($this->wrappedObject->banned_till)
        {
            return $this->wrappedObject->banned_till->toDayDateTimeString();
        }
        else
        {
            return "Life-time Ban";
        }
    }
}