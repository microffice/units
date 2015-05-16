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
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench'/**//*, [
            'driver'   => 'mysql',
            'host'     => 'localhost',
            'database' => 'microffice_test',
            'username' => 'laravel',
            'password' => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'   => '',
            'strict'    => false,
        ]/*/, [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]/**/);
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
}