<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * All properties that can be mass assigned
     *
     * @var array
     */
    protected $fillable = ['user_id','body'];

    protected $with = ['user'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Returns the owner of this comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function showBody()
    {
        \Emojione\Emojione::$ascii = true;
        \Emojione\Emojione::$imagePathPNG = '/components/emojione/assets/png/';
        \Emojione\Emojione::$cacheBustParam = '';
        $data = \Emojione\Emojione::toImage(nl2br(htmlspecialchars($this->body)));

        return linkify_new($data);
    }
}
