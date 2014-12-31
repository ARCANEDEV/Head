<?php namespace Arcanedev\Head\Tests\Support;

use Arcanedev\Head\Support\HTMLVersion;
use Arcanedev\Head\Tests\TestCase;

class HTMLVersionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const HTML_VERSION_CLASS = 'Arcanedev\\Head\\Support\\HTMLVersion';
    /** @var HTMLVersion */
    private $htmlVersion;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->htmlVersion = new HTMLVersion;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->htmlVersion);
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
        $this->assertInstanceOf(self::HTML_VERSION_CLASS, $this->htmlVersion);
        $this->assertEquals('5', $this->htmlVersion->get());

        $version = new HTMLVersion('4');
        $this->assertInstanceOf(self::HTML_VERSION_CLASS, $version);
        $this->assertEquals('4', $version->get());
    }

    /**
     * @test
     */
    public function testCanSetAndGetVersion()
    {
        $this->assertEquals('4', $this->htmlVersion->set('4')->get());
        $this->assertEquals('5', $this->htmlVersion->set('5')->get());

        $this->assertEquals('4', $this->htmlVersion->set(4)->get());
        $this->assertEquals('5', $this->htmlVersion->set(5)->get());
    }

    /**
     * @test
     */
    public function testCanCheckVersion()
    {
        $this->htmlVersion->set('5');
        $this->assertTrue($this->htmlVersion->isHTML5());

        $this->htmlVersion->set('4');
        $this->assertFalse($this->htmlVersion->isHTML5());
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\Exception
     */
    public function testMustThrowExceptionOnEmptyVersion()
    {
        $this->htmlVersion->set('');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeException()
    {
        $this->htmlVersion->set(true);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidHTMLVersionException
     */
    public function testMustThrowInvalidHTMLVersionException()
    {
        $this->htmlVersion->set('1');
    }
}
