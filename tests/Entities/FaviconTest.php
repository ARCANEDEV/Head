<?php namespace Arcanedev\Head\Tests\Entities;

namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Favicon;

class FaviconTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const FAVICON_CLASS = 'Arcanedev\\Head\\Entities\\Favicon';

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

        $this->favicon = (new Favicon)->set('favicon');
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
    public function test_can_be_instantiated()
    {
        $this->assertInstanceOf(self::FAVICON_CLASS, $this->favicon);
    }

    /** @test */
    public function test_can_render()
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
