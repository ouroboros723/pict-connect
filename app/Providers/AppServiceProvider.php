<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use SocialiteProviders\Discord\Provider as DiscordProvider;

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
        $socialite = $this->app->make(SocialiteFactory::class);
        $socialite->extend('discord', function ($app) use ($socialite) {
            $config = $app['config']['services.discord'];
            return $socialite->buildProvider(DiscordProvider::class, $config);
        });
    }
}
