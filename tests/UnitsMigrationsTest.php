<?php namespace Microffice\Units\Tests;

class UnitsMigrationsTest extends UnitsBaseTest {
    
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        // generate migrations
        $this->artisan('units:migration', [
            '-ut' => null,
        ]);
        //require_once __DIR__.'/seeds/UnitsSeeder.php';
        /**/
        // 'artisan migrate --database' option is the connection to use
        // as usually available in config/database.php


        // uncomment to enable route filters if your package defines routes with filters
        // $this->app['router']->enableFilters();

        // call migrations for packages upon which our package depends, e.g. Cartalyst/Sentry
        // not necessary if your package doesn't depend on another package that requires
        // running migrations for proper installation
        /* uncomment as necessary
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--path'     => '../vendor/cartalyst/sentry/src/migrations',
        ]);
        */

        // call migrations specific to our tests, e.g. to seed the db
        // the path option should be relative to the 'path.database'
        // path unless `--path` option is available.
        /*$this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/migrations'),
        ]);/**/

        // call seeds specific to our tests, e.g. to seed the db
        // the path option should be relative to the 'path.database'
        // path unless `--path` option is available.
        /*$this->artisan('db:seed', [
            '--database' => 'testbench',
            '--class' => 'Microffice\Units\Tests\UnitsSeeder'
        ]);/**/
    }

    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            //'Cartalyst\Sentry\SentryServiceProvider',
            //'YourProject\YourPackage\YourPackageServiceProvider',
            'Microffice\Units\UnitServiceProvider'
        ];
    }

    /**
     * Get package aliases.  In a normal app environment these would be added to
     * the 'aliases' array in the config/app.php file.  If your package exposes an
     * aliased facade, you should add the alias here, along with aliases for
     * facades upon which your package depends, e.g. Cartalyst/Sentry.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //'Sentry'      => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
            //'YourPackage' => 'YourProject\YourPackage\Facades\YourPackage',
            'Units' => 'Microffice\Units\Facades\Unit'
        ];
    }

    /**
     * Test running migration.
     *
     * @test
     */
    public function testRunningMigration()
    {
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/migrations'),
        ]);

        $this->assertTrue(\Schema::hasTable(\Config::get('units.table_name')));

        \Schema::dropIfExists(\Config::get('units.table_name'));
        \Schema::dropIfExists('migrations');
    }

    /**
     * Test running migration.
     *
     * @test
     */
    public function testRunningSeed()
    {
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/migrations'),
            '--seed' => null
        ]);

        $units = \DB::table(\Config::get('units.table_name'))->where('id', '=', 1)->first();

        $this->assertEquals('m', $units->unit);

        \Schema::dropIfExists(\Config::get('units.table_name'));
        \Schema::dropIfExists('migrations');/**/
    }

}
