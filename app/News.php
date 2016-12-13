<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'summary', 'text', 'is_published', 'news_type'];

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
     * Return collection of all published news
     *
     * @return mixed
     */
    public function allPublishedGlobal()
    {
        return $this->where('is_published',1)->where('news_type','0')->latest()->get();
    }

    /**
     * Return collection of all published news
     *
     * @return mixed
     */
    public function allPublishedTournament()
    {
        return $this->where('is_published',1)->where('news_type','1')->latest()->get();
    }

    /**
     * Return latest news for sidebar
     *
     * @return mixed
     */
    public static function forSidebar()
    {
       $data = new static;
        return $data->allPublishedGlobal()->take(2);
    }

    /**
     * Return latest news for tourny sidebar
     *
     * @return mixed
     */
    public static function forSidebarTournament()
    {
        $data = new static;
        return $data->allPublishedTournament()->take(3);
    }

    /**
     * @return string
     */
    public function getHumanReadableNewsType()
    {
        switch ($this->news_type)
        {
            case 0:
                return "Global News";
                break;
            case 1:
                return "Tournament News";
                break;
            default:
                return "Global News";
                break;
        }
    }
}
