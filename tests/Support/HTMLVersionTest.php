<?php namespace Arcanedev\Head\Tests\Support;

use Arcanedev\Head\Support\HTMLVersion;
use Arcanedev\Head\Tests\TestCase;

/**
 * Class HTMLVersionTest
 * @package Arcanedev\Head\Tests\Support
 */
class HTMLVersionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
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
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->htmlVersion = new HTMLVersion;
        $this->assertInstanceOf(HTMLVersion::class, $this->htmlVersion);
        $this->assertEquals('5', $this->htmlVersion->get());

        $this->htmlVersion = new HTMLVersion('4');
        $this->assertInstanceOf(HTMLVersion::class, $this->htmlVersion);
        $this->assertEquals('4', $this->htmlVersion->get());
    }

    /** @test */
    public function it_can_set_and_get_version()
    {
        $this->assertEquals('4', $this->htmlVersion->set('4')->get());
        $this->assertEquals('5', $this->htmlVersion->set('5')->get());

        $this->assertEquals('4', $this->htmlVersion->set(4)->get());
        $this->assertEquals('5', $this->htmlVersion->set(5)->get());
    }

    /** @test */
    public function it_can_check_version()
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
    public function it_must_throw_exception_on_empty_version()
    {
        $this->htmlVersion->set('');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function it_must_throw_invalid_type_exception()
    {
        $this->htmlVersion->set(true);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidHTMLVersionException
     */
    public function it_must_throw_invalid_html_version_exception()
    {
        $this->htmlVersion->set('1');
    }
}
