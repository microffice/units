<?php namespace Microffice\Units;

use Illuminate\Support\ServiceProvider;

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
    protected $defer = false;

    /**
    * Bootstrap the application.
    *
    * @return void
    */
    public function boot()
    {
        // The publication files to publish
        $this->publishes([__DIR__ . '/../../config/config.php' => config_path('units.php')]);

        // Append the country settings
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php', 'units'
        );
        /*$this->app['config']['database.connections'] = array_merge(
            $this->app['config']['database.connections'],
            \Config::get('career.library.database.connections')
        );*/
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
            return new Unit();
        });
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
        return array('units');
    }
}