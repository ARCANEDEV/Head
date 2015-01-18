<?php namespace Arcanedev\Head\Tests\Laravel;

use Arcanedev\Head\Laravel\ServiceProvider;
use Arcanedev\Head\Tests\LaravelTestCase;

class ServiceProviderTest extends LaravelTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var ServiceProvider */
    private $serviceProvider;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->serviceProvider = new ServiceProvider($this->app);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->serviceProvider);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @test
     */
    public function testCanGetWhatHeProvides()
    {
        // This is for 100% code converge
        $this->assertEquals([
            'arcanedev.head'
        ], $this->serviceProvider->provides());
    }
}
