<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loadout extends Model
{
    protected $fillable = ['primary_weapon','primary_ammo','secondary_weapon','secondary_ammo','equip_one','equip_two','equip_three','equip_four','equip_five','breacher','body','head'];

    /**
     * Return all players which bears same Loadout ;)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany('App\Player');
    }

    /**
     * Return all profiles that bears same Loadout during their last game ;)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profiles()
    {
        return $this->hasMany('App\Profile');
    }

    /**
     * Check if its already empty
     *
     * @return bool
     */
    public function kyaKhali()
    {
        return ($this->primary_weapon == 0 && $this->secondary_weapon == 0);
    }
}
