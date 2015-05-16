<?php namespace Microffice\Units\Tests;

class UnitsMigrationCommandTest extends UnitsBaseTest {
    
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();
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
            'Units' => 'Microffice\Units\Facades\Unit'
        ];
    }

    /**
     * Test checkMigrationsDirectoriesExists.
     *
     * @test
     */
    public function testCheckMigrationsDirectoriesExists()
    {
        $path = __DIR__."/pathForUnittesting";

        $object = new \Microffice\Units\MigrationCommand();
        $method = $this->getPrivateMethod( 'Microffice\Units\MigrationCommand', 'checkMigrationsDirectoriesExists');

        $result = $method->invokeArgs( $object, array( $path ) );

        $this->assertTrue(file_exists($path));

        if(file_exists($path))
        {
            $this->emptyDirectory($path);
            rmdir($path);
        }
    }

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
     * Test running migration with --unittesting option flag.
     *
     * @test
     */
    public function testRunningCommandWithUnittestingOption()
    {
        $this->artisan('units:migration', [
            '-ut' => null,
        ]);

        $path = __DIR__.'/seeds';
        $this->assertTrue(file_exists($path.'/UnitsSeeder.php'));
        $this->emptyDirectory($path);
        rmdir($path);

        $path = __DIR__.'/migrations';
        $array = iterator_to_array(new \GlobIterator($path.'/*_create_units_table.php', \GlobIterator::CURRENT_AS_PATHNAME));
        $this->assertNotEmpty($array);
        $this->emptyDirectory($path);
        rmdir($path);
    }

    /**
     * Test running migration with --path option flag.
     *
     * @test
     */
    public function testRunningCommandWithPathOption()
    {
        $basePath = __DIR__.'/unitTestingPath';
        $this->artisan('units:migration', [
            '-ut' => null,
            '-p' => $basePath
        ]);

        $path = $basePath.'/seeds';
        $this->assertTrue(file_exists($path));
        $this->emptyDirectory($path);

        $path = $basePath.'/migrations';
        $this->assertTrue(file_exists($path));
        $this->emptyDirectory($path);

        $this->emptyDirectory($basePath);
        rmdir($basePath);
    }
}
