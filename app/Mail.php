<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mail extends Model
{
    use SoftDeletes;

    protected $fillable = ['sender_id','reciever_id','message'];

    protected $dates = ['seen_at'];

    public function sender()
    {
      return $this->belongsTo('App\User','sender_id');
    }

    public function reciever()
    {
      return $this->belongsTo('App\User','reciever_id');
    }

    /**
     * Return Conversation between 2 users
     *
     * @param $user1
     * @param $user2
     * @return mixed
     */
    public static function conversation($user1,$user2)
    {
        $conv = static::where(function($q) use($user1,$user2){
            $q->where('sender_id',$user1->id)->where('reciever_id',$user2->id);
        })->orWhere(function($q) use($user1,$user2){
            $q->where('sender_id',$user2->id)->where('reciever_id',$user1->id);
        });
        return $conv;
    }

    public function hasBeenSeen()
    {
        $this->seen_at = Carbon::now();
        $this->save();
    }

    public function canBeDeletedBy(User $user)
    {
        /**
         * For Admin View
         * It disable delete btn in admin view when viewed with trashed
         */
        if(!is_null($this->deleted_at))
        {
            return false;
        }

        if($user->isSuperAdmin())
        {
            return true;
        }
        return $user->id === $this->sender_id;
    }
}
