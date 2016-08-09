<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable   = ['user_id', 'type', 'subject', 'body', 'object_id', 'object_type', 'sent_at'];

    protected $dates = ['sent_at'];

    private $relatedObject = null;

    /*public function getDates()
    {
        return ['created_at', 'updated_at', 'sent_at'];
    }*/

    /**
     * Receiver of this notification
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', '=', 0);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeStream($query)
    {
        return $query->where('is_stream', '=', 1);
    }

    /**
     * @param $user
     * @return $this
     */
    public function from($user)
    {
        $this->sender()->associate($user);

        return $this;
    }

    /**
     * @param $subject
     * @return $this
     */
    public function withSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param $body
     * @return $this
     */
    public function withBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function withType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param $stream
     * @return $this
     */
    public function withStream($stream)
    {
        $this->is_stream = $stream;

        return $this;
    }

    /**
     * @param $object
     * @return $this
     */
    public function regarding($object)
    {
        if(is_object($object))
        {
            $this->object_id   = $object->id;
            $this->object_type = get_class($object);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function deliver()
    {
        $this->sent_at = new Carbon;
        $this->save();

        return $this;
    }

    /**
     * @return bool
     */
    public function hasValidObject()
    {
        try
        {
            $object = call_user_func_array($this->object_type . '::findOrFail', [$this->object_id]);
        }
        catch(\Exception $e)
        {
            return false;
        }

        $this->relatedObject = $object;

        return true;
    }

    /**
     * @return null
     * @throws \Exception
     */
    public function getObject()
    {
        if($this->relatedObject)
        {
            $hasObject = $this->hasValidObject();

            if(!$hasObject)
            {
                throw new \Exception(sprintf("No valid object (%s with ID %s) associated with this notification.", $this->object_type, $this->object_id));
            }
        }
        return $this->relatedObject;
    }

    public function getUnreadColorClass()
    {
        if($this->is_read)
        {
        }
        else
        {
            $this->is_read = true;
            $this->save();
            return "notification-unread";
        }
    }
}
