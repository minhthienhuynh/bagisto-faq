<?php

namespace DFM\FAQ\Providers;

use Illuminate\Support\ServiceProvider;

class FaqServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/concord-modules.php', 'concord.modules'
        );
        $this->mergeConfigFrom(
            __DIR__.'/../../config/menu-admin.php', 'menu.admin'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'dfm-faq');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'dfm-faq');

        $this->publishes([
            __DIR__.'/../../config/dfm-faq.php' => config_path('dfm-faq.php')
        ], 'faq-config');

        $this->publishes([
            __DIR__.'/../../database/migrations/' => database_path('migrations')
        ], 'faq-migrations');

        $this->publishes([
            __DIR__.'/../../resources/assets' => resource_path('assets/vendor/dfm-faq'),
        ], 'faq-assets');

        $this->publishes([
            __DIR__.'/../../resources/lang' => resource_path('lang/vendor/dfm-faq'),
        ], 'faq-lang');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/dfm-faq'),
        ], 'faq-views');
    }
}
