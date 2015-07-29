<?php namespace Microffice\Units\Tests;
use \Orchestra\Testbench\TestCase as TestCase;

class UnitsBaseTest extends TestCase {
    
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * Tear the test environment down.
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('database.connections.testbench_mysql', [
            'driver'   => 'mysql',
            'host'     => 'localhost',
            'database' => 'microffice_test',
            'username' => 'laravel',
            'password' => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'   => '',
            'strict'    => false,
        ]);
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
            'Microffice\Units\UnitServiceProvider',
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
            'Unit' => 'Microffice\Support\Facades\Unit',
        ];
    }

    /**
    * getPrivateMethod
    *
    * @author Joe Sexton <joe@webtipblog.com>
    * @param string $className
    * @param string $methodName
    * @return ReflectionMethod
    */
    public function getPrivateMethod( $className, $methodName ) {
        $reflector = new \ReflectionClass( $className );
        $method = $reflector->getMethod( $methodName );
        $method->setAccessible( true );
         
        return $method;
    }

    /**
    * getPrivateProperty
    *
    * @author Joe Sexton <joe@webtipblog.com>
    * @param string $className
    * @param string $propertyName
    * @return ReflectionProperty
    */
    public function getPrivateProperty( $className, $propertyName ) {
        $reflector = new \ReflectionClass( $className );
        $property = $reflector->getProperty( $propertyName );
        $property->setAccessible( true );
         
        return $property;
    }

    /**
     * Empty a directory 
     *
     */
    protected function emptyDirectory($path)
    {
        $iterator = new \DirectoryIterator($path);
        while($iterator->valid()) {
            if($iterator->isFile())
            {
                unlink($iterator->getPathname());
            }
            elseif ($iterator->isDir() && (! $iterator->isDot()))
            {
                rmdir($iterator->getPathname());
            }
            $iterator->next();
        }
    }

    /**
     * Create the Migration and Seed files
     *
     */
    protected function createMigrations()
    {
        $path = __DIR__.'/migrations';
        $array = iterator_to_array(new \GlobIterator($path.'/*_create_units_table.php', \GlobIterator::CURRENT_AS_PATHNAME));
        if(empty($array))
        {
            // generate migrations
            $this->artisan('units:migration', [
                '-ut' => null,
            ]);/**/
        }
    }

    /**
     * Migrate and seed DB
     *
    * @param string $dbConnection
    * @param bool   $seed
    * @return void
     */
    protected function migrate($dbConnection = 'testbench', $seed = true)
    {
        $this->artisan('migrate', [
            '--database' => $dbConnection,
            '--realpath' => realpath(__DIR__.'/migrations')
        ]);
        // We need to separate seed command to pass the correct --class option
        if($seed)
        {
            $this->artisan('db:seed', [
                '--database' => $dbConnection,
                '--class' => 'UnitsSeeder'
            ]);/**/
        }
    }

    /**
     * empty Test to get rid of warning 'No Test in UnitBaseTest'
     *
     * @test
     */
    public function test()
    {
       
    }
}