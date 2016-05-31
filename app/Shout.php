<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shout extends Model
{
    use SoftDeletes;

    protected $fillable = ['shout'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
