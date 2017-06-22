<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iphistory extends Model
{
    protected $fillable = ['ip','user_id'];

    public function user()
    {
        $this->belongsTo('App\User');
    }
}

