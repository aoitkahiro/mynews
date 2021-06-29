<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // HTTPをHTTPS に 通信プロトコルを変更するために以下を追記
        if (\App::environment('production')) {
            \URL::forceScheme('https');
    }
    }
}
