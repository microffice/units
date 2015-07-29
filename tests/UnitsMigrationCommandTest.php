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
     * Tear the test environment down.
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Test checkMigrationsDirectoriesExists.
     *
     * @test
     * @group ArtisanCommandTests
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
    }/**/

    /**
     * Test running migration with --unittesting option flag.
     *
     * @test
     * @group ArtisanCommandTests
     */
    public function testRunningCommandWithUnittestingOption()
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
        $array = iterator_to_array(new \GlobIterator($path.'/*_create_units_table.php', \GlobIterator::CURRENT_AS_PATHNAME));
        $this->assertNotEmpty($array);

        $path = __DIR__.'/seeds';
        $this->assertTrue(file_exists($path.'/UnitsSeeder.php'));
    }/**/

    /**
     * Test running migration with --path option flag.
     *
     * @test
     * @group ArtisanCommandTests
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
    }/**/
}
