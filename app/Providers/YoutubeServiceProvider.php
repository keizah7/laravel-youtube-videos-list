<?php

namespace App\Providers;

use App\Services\Youtube;
use Illuminate\Support\ServiceProvider;

class YoutubeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Youtube::class, function() {
            return new Youtube(
                config('youtube.oauth_client_id'),
                config('youtube.oauth_client_secret'),
                config('youtube.api_key'),
            );
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
