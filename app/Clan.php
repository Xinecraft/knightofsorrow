<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clan extends Model
{
    protected $fillable = ['name','tag','image','gamename','gamemode','founded_on','leader','motto','description','website','shortname','    protected $fillable = [\'name\',\'tag\',\'image\',\'gamename\',\'gamemode\',\'founded_on\',\'leader\',\'motto\',\'description\',\'website\',\'shortname\',\'\'];
','submitter_id'];

    protected $dates = ['founded_on'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User','submitter_id','id');
    }
}
