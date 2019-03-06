<?php

namespace Technovistalimited\Shongjukti;

use Illuminate\Support\ServiceProvider;

class ShongjuktiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    	// ----------------------------
        // PUBLISH --------------------
        // ----------------------------

    	// config
    	$this->publishes([__DIR__ .'/config/shongjukti.php' => config_path('shongjukti.php')], 'shongjukti');

        // migrations
    	$this->publishes([__DIR__ .'/migrations/' => database_path('migrations')], 'shongjukti');

        // views
    	$this->publishes([__DIR__ .'/resources/views' => resource_path('views/vendor/shongjukti')], 'shongjukti');

        // language files
    	$this->publishes([__DIR__ .'/resources/lang' => resource_path('lang/vendor/shongjukti')], 'shongjukti');

        // publish js and css files
    	$this->publishes([__DIR__ .'/resources/assets' => public_path('vendor/shongjukti')], 'shongjukti');


		// ----------------------------
	    // LOAD -----------------------
	    // ----------------------------

    	// config
    	$this->mergeConfigFrom(__DIR__ .'/config/shongjukti.php', 'shongjukti');

	    // routes
    	$this->loadRoutesFrom(__DIR__ .'/routes/routes.php');

	    // language files
    	$this->loadTranslationsFrom(__DIR__ .'/resources/lang', 'shongjukti');

	    // views
    	$this->loadViewsFrom(__DIR__ .'/resources/views', 'shongjukti');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	if ($this->app['config']->get('shongjukti') === null) {
    		$this->app['config']->set('shongjukti', require __DIR__ .'/config/shongjukti.php');
    	}

    	$this->app->singleton('shongjukti', function ($app) {
            return new Shongjukti();
        });
    }
}
