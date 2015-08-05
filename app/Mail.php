<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{

    protected $fillable = ['sender_id','reciever_id','subject','body'];

    protected $dates = ['seen_at'];

    public function sender()
    {
      return $this->belongsTo('App\User','sender_id');
    }

    public function reciever()
    {
      return $this->belongsTo('App\User','reciever_id');
    }
}
