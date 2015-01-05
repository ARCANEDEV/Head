<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Stylesheet;

class StylesheetTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Stylesheet */
    private $stylesheet;

    const STYLESHEET_CLASS = 'Arcanedev\\Head\\Entities\\Stylesheet';

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
    public function testCanBeInstantiated()
    {
        $this->assertInstanceOf(self::STYLESHEET_CLASS, $this->stylesheet);
    }

    /**
     * @test
     */
    public function testCanSetAndGetSource()
    {
        $src  = 'assets/css/style.css';
        $this->stylesheet->setSrc($src);

        $this->assertEquals($src, $this->stylesheet->getSrc());
    }

    /**
     * @test
     */
    public function testCanGetFilenameFromSource()
    {
        $this->assertEquals('', $this->stylesheet->getFile());

        $file = "style.css";
        $src  = "assets/css/$file";
        $this->stylesheet->setSrc($src);

        $this->assertEquals($file, $this->stylesheet->getFile());
    }

    /**
     * @test
     */
    public function testCanGetType()
    {
        $this->assertEquals('text/css', $this->stylesheet->getType());
    }

    /**
     * @test
     */
    public function testCanMakeStylesheet()
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
    public function testCanRender()
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
