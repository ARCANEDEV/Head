<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Stylesheet;

class StylesheetTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const STYLESHEET_CLASS = 'Arcanedev\\Head\\Entities\\Stylesheet';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Stylesheet */
    private $stylesheet;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->stylesheet = new Stylesheet;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->stylesheet);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @test
     */
    public function test_can_be_instantiated()
    {
        $this->assertInstanceOf(self::STYLESHEET_CLASS, $this->stylesheet);
    }

    /**
     * @test
     */
    public function test_can_set_and_get_source()
    {
        $src  = 'assets/css/style.css';
        $this->stylesheet->setSrc($src);

        $this->assertEquals($src, $this->stylesheet->getSrc());
    }

    /**
     * @test
     */
    public function test_can_get_filename_from_source()
    {
        $this->assertEquals('', $this->stylesheet->getFile());

        $file = 'style.css';
        $src  = "assets/css/$file";
        $this->stylesheet->setSrc($src);

        $this->assertEquals($file, $this->stylesheet->getFile());
    }

    /**
     * @test
     */
    public function test_can_get_type()
    {
        $this->assertEquals('text/css', $this->stylesheet->getType());
    }

    /**
     * @test
     */
    public function test_can_make_stylesheet()
    {
        $file = "style.css";
        $src  = "assets/css/$file";
        $this->stylesheet = Stylesheet::make($src);

        $this->assertInstanceOf(self::STYLESHEET_CLASS, $this->stylesheet);
        $this->assertEquals($src, $this->stylesheet->getSrc());
        $this->assertEquals($file, $this->stylesheet->getFile());
    }

    /**
     * @test
     */
    public function test_can_render()
    {
        $this->assertEquals('', $this->stylesheet->render());

        $src  = 'assets/css/style.css';
        $type = 'type="text/css"';
        $this->stylesheet->setSrc($src);

        $this->assertEquals(
            "<link rel=\"stylesheet\" src=\"$src\">",
            $this->stylesheet->render()
        );

        $this->stylesheet->setVersion(4);
        $this->assertEquals(
            "<link rel=\"stylesheet\" $type src=\"$src\">",
            $this->stylesheet->render()
        );
    }
}
