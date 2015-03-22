<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Script;

class ScriptTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const SCRIPT_CLASS = 'Arcanedev\\Head\\Entities\\Script';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Script */
    protected $script;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->script = new Script;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->script);
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
        $this->assertInstanceOf(self::SCRIPT_CLASS, $this->script);
    }

    /**
     * @test
     */
    public function test_can_set_and_get_source()
    {
        $src  = 'assets/js/jquery-min.js';
        $this->script->setSrc($src);

        $this->assertEquals($src, $this->script->getSrc());
    }

    /**
     * @test
     */
    public function test_can_get_filename_from_source()
    {
        $this->assertEquals('', $this->script->getFile());

        $file = 'jquery-min.js';
        $src  = "assets/js/$file";
        $this->script->setSrc($src);

        $this->assertEquals($file, $this->script->getFile());
    }

    /**
     * @test
     */
    public function test_can_make_script()
    {
        $file = 'jquery-min.js';
        $src  = "assets/js/$file";
        $this->script = Script::make($src);

        $this->assertInstanceOf(self::SCRIPT_CLASS, $this->script);
        $this->assertEquals($src, $this->script->getSrc());
        $this->assertEquals($file, $this->script->getFile());
    }

    /**
     * @test
     */
    public function test_can_render()
    {
        $this->assertEquals('', $this->script->render());

        $src  = 'assets/js/jquery-min.js';
        $type = 'type="text/javascript"';
        $this->script->setSrc($src);

        $this->assertEquals(
            "<script src=\"$src\"></script>",
            $this->script->render()
        );

        $this->script->setVersion(4);
        $this->assertEquals(
            "<script $type src=\"$src\"></script>",
            $this->script->render()
        );
    }
}
