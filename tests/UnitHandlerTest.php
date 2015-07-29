<?php namespace Microffice\Units\Tests;

use Microffice\Units\UnitModel;

class UnitTest extends UnitsBaseTest {
    
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->createMigrations();
    }
    
    /**
     * Tear the test environment down.
     */
    public function tearDown()
    {
        parent::tearDown();
        
    }

    /**
     * Test create should return view
     *
     * @test
     */
    public function testCreateShouldReturnView()
    {
        $response = \Unit::create();
        $this->assertInstanceOf('Illuminate\View\View', $response);
    }

    /**
     * Test create should return empty $data with view
     *
     * @test
     */
    public function testCreateShouldReturnEmptyData()
    {
        $response = \Unit::create();
        $property = $this->getPrivateProperty( 'Illuminate\View\View', 'data');
        $array = $property->getValue($response);

        $this->assertObjectHasAttribute('data', $response);
        $this->assertEmpty($array);
    }

    /**
     * Test edit should return view
     *
     * @test
     */
    public function testEditShouldReturnView()
    {
        $this->migrate('testbench_mysql');

        $response = \Unit::edit(1);
        $this->assertInstanceOf('Illuminate\View\View', $response);
        //var_dump($response);
    }

    /**
     * Test edit should return filled $data
     *
     * @test
     */
    public function testEditShouldReturnFilledData()
    {
        $this->migrate('testbench_mysql');

        $response = \Unit::edit(1);
        $property = $this->getPrivateProperty( 'Illuminate\View\View', 'data');
        $array = $property->getValue($response);

        $this->assertObjectHasAttribute('data', $response);
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('unit', $array);
        //var_dump($array);
    }

}
