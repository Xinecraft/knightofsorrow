<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trophy extends Model
{
    protected $fillable = ['name', 'short_name', 'description', 'photo_id', 'icon', 'koins', 'max_bearer', 'color'];

    /**
     * Admin/Creator of this trophy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Users holding this trophy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }
}
