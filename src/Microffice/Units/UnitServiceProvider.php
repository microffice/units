<?php namespace Microffice\Units;

use Illuminate\Support\ServiceProvider;
use Microffice\Units\UnitHandler;

/**
 * UnitServiceProvider
 *
 */ 

class UnitServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
    * Bootstrap the application.
    *
    * @return void
    */
    public function boot()
    {
        // The publication files to publish
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('units.php'),
            __DIR__ . '/../../views' => base_path('resources/views/microffice/units'),
        ]);

        // Append the units settings
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'units');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../views', 'units');
    }
        
    /**
     * Register everything.
     *
     * @return void
     */
    public function register()
    {
        $this->registerUnit();
        $this->registerCommands();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerUnit()
    {   
        $this->app->bind('unit', function($app)
        {
            $handler = \Config::get('units.handler');
            return new $handler();
        });/**/
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->app['command.units.migration'] = $this->app->share(function($app)
        {
            return new MigrationCommand($app);
        });

        $this->commands('command.units.migration');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        //return ['Microffice\Contracts\Units\UnitHandler'];
        return ['unit'];
    }
}