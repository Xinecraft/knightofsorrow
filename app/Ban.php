<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;
use App\Server\Presenters\BanPresenter;

class Ban extends Model implements HasPresenter
{
    protected $fillable = ['name', 'ip_address', 'server_id', 'country_id', 'reason', 'admin_name', 'admin_ip', 'status', 'created_by_site', 'updated_by_site'];

    /**
     * @return BanPresenter
     */
    public function getPresenterClass()
    {
        return BanPresenter::class;
    }

    /**
     * Returns Country instance to which this Player belongs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public static function findOrNullByIP($ip)
    {
        return static::where('ip_address','LIKE',$ip)->first();
    }
}
