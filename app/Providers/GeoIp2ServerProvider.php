<?php

namespace App\Providers;

use GeoIp2\Database\Reader;
use Illuminate\Support\ServiceProvider;

class GeoIp2ServerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('geoip',function()
        {
            return new Reader(storage_path().DIRECTORY_SEPARATOR.'GeoLite2-City.mmdb');
        });
    }
}
