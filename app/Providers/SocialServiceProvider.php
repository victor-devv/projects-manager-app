<?php

namespace App\Providers;

use App\Services\Twitter;
use Illuminate\Support\ServiceProvider;

class SocialServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
        $this->app->singleton(Twitter::class, function(){

            // return new Twitter('api-key');

            //USE CONFIG VAR(WHICH REFLECTS THE API KEY VALUE SEST IN THE .ENV FILE)
            return new Twitter(config('services.twitter.secret'));

            
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
