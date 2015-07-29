<?php namespace Microffice\Units\Tests;

class UnitsMigrationsTest extends UnitsBaseTest {
    
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->createMigrations();
        
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
     * Tear the test environment down.
     */
    public function tearDown()
    {
        parent::tearDown();
        
        /*$path = __DIR__.'/seeds';
        $this->emptyDirectory($path);
        rmdir($path);

        $path = __DIR__.'/migrations';
        $this->emptyDirectory($path);
        rmdir($path);/**/
        //\Schema::dropIfExists(\Config::get('units.table_name'));
        //\Schema::dropIfExists('migrations');
    }

    /**
     * Test running migration.
     *
     * @test
     * @group ApplicationTests
     */
    public function testRunningMigration()
    {
        $this->migrate('testbench_mysql', false);

        $this->assertTrue(\Schema::hasTable(\Config::get('units.table_name')));

        \Schema::dropIfExists(\Config::get('units.table_name'));
        \Schema::dropIfExists('migrations');/**/
    }

    /**
     * Test running migration.
     *
     * @test
     * @group ApplicationTests
     */
    public function testRunningSeed()
    {
        $this->artisan('migrate', [
            '--database' => 'testbench_mysql',
            '--realpath' => realpath(__DIR__.'/migrations')/**/
        ]);
        // We need to separate seed command to pass the correct --class option
        $this->artisan('db:seed', [
            '--database' => 'testbench_mysql',
            '--class' => 'UnitsSeeder'
        ]);/**/

        $units = \DB::table(\Config::get('units.table_name'))->where('id', '=', 1)->first();

        $this->assertEquals('m', $units->unit);

        \Schema::dropIfExists(\Config::get('units.table_name'));
        \Schema::dropIfExists('migrations');/**/
    }

}
