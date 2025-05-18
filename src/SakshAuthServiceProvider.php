<?php 

namespace Sakshsky\SakshAuth;

use Illuminate\Support\ServiceProvider;

class SakshAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'saksh-auth-migrations');

        // Publish config file
        $this->publishes([
            __DIR__.'/../config/saksh-auth.php' => config_path('saksh-auth.php'),
        ], 'saksh-auth-config');

        // Register event listeners
        $this->app['events']->listen(Events\OtpGenerated::class, Listeners\SendOtpEmail::class);
    }

    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__.'/../config/saksh-auth.php', 'saksh-auth');
    }
}