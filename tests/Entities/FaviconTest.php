<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Favicon;

/**
 * Class FaviconTest
 * @package Arcanedev\Head\Tests\Entities
 */
class FaviconTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Favicon */
    private $favicon;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->favicon = new Favicon('favicon');
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->favicon);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->favicon = new Favicon;
        $this->assertInstanceOf(Favicon::class, $this->favicon);
        $this->assertEmpty($this->favicon->render());
    }

    /** @test */
    public function it_can_render()
    {
        $this->assertEquals(
            implode(PHP_EOL, [
                '<link href="' . base_url('favicon.ico') . '" rel="icon" type="image/x-icon"/>',
                '<link href="' . base_url('favicon.png') . '" rel="icon" type="image/png"/>'
            ]),
            $this->favicon->render()
        );
    }
}
