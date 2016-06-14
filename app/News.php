<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'summary', 'text', 'is_published'];

    /**
     * Return writer of this News
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Return collection of all published news
     *
     * @return mixed
     */
    public function allPublished()
    {
        return $this->where('is_published',1)->latest()->get();
    }

    /**
     * Return latest news for sidebar
     *
     * @return mixed
     */
    public static function forSidebar()
    {
       $data = new static;
        return $data->allPublished()->take(2);
    }
}
