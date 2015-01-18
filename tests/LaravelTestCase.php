<?php namespace Arcanedev\Head\Tests;

abstract class LaravelTestCase extends \Orchestra\Testbench\TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register Service Providers
     *
     * @return array
     */
    protected function getPackageProviders()
    {
        return [
            'Arcanedev\Head\Laravel\ServiceProvider'
        ];
    }

    /**
     * Register Aliases
     *
     * @return array
     */
    protected function getPackageAliases()
    {
        return [
            'Facade' => 'Arcanedev\Head\Laravel\Facade'
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
    }
}
