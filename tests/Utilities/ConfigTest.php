<?php namespace Arcanedev\Head\Tests\Utilities;

use Arcanedev\Head\Tests\TestCase;
use Arcanedev\Head\Utilities\Config;

class ConfigTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const CONFIG_CLASS = 'Arcanedev\\Head\\Utilities\\Config';
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
        $this->assertInstanceOf(self::CONFIG_CLASS, $this->config);
    }
}
