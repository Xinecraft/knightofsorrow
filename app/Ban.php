<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;
use App\Server\Presenters\BanPresenter;

class Ban extends Model implements HasPresenter
{
    protected $fillable = ['name', 'ip_address', 'server_id', 'country_id', 'reason', 'admin_name', 'admin_ip', 'status', 'created_by_site', 'updated_by_site','banned_till'];

    protected $dates = ['banned_till'];
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

    /**
     * Returns all comments of this Ban.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany('App\Comment','commentable');
    }

    /**
     * @return string
     */
    public function ipAddrWithMask()
    {
        $ip = $this->ip_address;
        $ip = explode('.',$ip);

        return $ip[0].".".$ip[1].".xx.xx";
    }

    /**
     * @return string
     */
    public function countryImage()
    {
        return "/images/flags/20_shiny/".$this->country->countryCode.".png";
    }

    /**
     * @return mixed
     */
    public function countryName()
    {
        $name = $this->country->countryName;

        if(str_contains($name,", "))
        {
            $name = explode(", ",$name);
            return $name[1]." ".$name[0];
        }
        return $name;
    }

    /**
     * When Ban is Added then do a admin command to post at SWAT4 Server
     */
    public function tellServerToAdd()
    {
        $admin = \Auth::user()->displayName();
        $playerip = trim($this->ip_address);
        $action = 'addban';

        $command = env("ADMIN_COMMAND_SECRET")." ".$admin." ".$action." ".$playerip." 0 ".$this->reason;

        //dd($command);

        $txtip = "127.0.0.1";
        $txtportnum = "10485";
        $sock = fsockopen("udp://" . $txtip, $txtportnum, $errno, $errstr, 2);
        if (!$sock) {
            echo "$errstr ($errno)<br/>\n";
            exit;
        }
        fputs($sock, $command);
        $gotfinal = False;
        $data = "";
        socket_set_timeout($sock, 0, 1000);
        fclose($sock);
    }

    /**
     * When ban removed from website do a admin command to remove at SWAT4
     */
    public function tellServerToRemove()
    {
        $admin = \Auth::user()->displayName();
        $playerip = trim($this->ip_address);
        $action = 'removeban';

        $command = env("ADMIN_COMMAND_SECRET")." ".$admin." ".$action." ".$playerip;

        $txtip = "127.0.0.1";
        $txtportnum = "10485";
        $sock = fsockopen("udp://" . $txtip, $txtportnum, $errno, $errstr, 2);
        if (!$sock) {
            echo "$errstr ($errno)<br/>\n";
            exit;
        }
        fputs($sock, $command);
        $gotfinal = False;
        $data = "";
        socket_set_timeout($sock, 0, 1000);
        fclose($sock);
    }

}
