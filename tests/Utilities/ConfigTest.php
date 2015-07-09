<?php namespace Arcanedev\Head\Tests\Utilities;

use Arcanedev\Head\Tests\TestCase;
use Arcanedev\Head\Utilities\Config;

/**
 * Class ConfigTest
 * @package Arcanedev\Head\Tests\Utilities
 */
class ConfigTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Config */
    private $config;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->config = new Config;
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Config::class, $this->config);
    }
}
