<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    protected $fillable = ['server_ip', 'server_port', 'server_uid', 'type', 'playerone', 'playerone_ip', 'playertwo', 'playertwo_ip', 'extra'];
}
