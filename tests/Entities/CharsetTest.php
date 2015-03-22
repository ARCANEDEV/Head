<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Charset;

class CharsetTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const CHARSET_CLASS = 'Arcanedev\\Head\\Entities\\Charset';
    const UTF_CHARSET   = 'UTF-8';
    const ISO_CHARSET   = 'ISO-8859-15';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Charset */
    protected $charset;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function setUp()
    {
        $this->charset = new Charset;
    }

    protected function tearDown()
    {
        unset($this->charset);
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
        $this->assertInstanceOf(self::CHARSET_CLASS, $this->charset);
    }

    /**
     * @test
     */
    public function test_can_set_and_get_charset()
    {
        $this->assertEquals(self::UTF_CHARSET, $this->charset->get());

        $this->charset->set(self::ISO_CHARSET);
        $this->assertEquals(self::ISO_CHARSET, $this->charset->get());

        $this->charset->set(strtolower(self::UTF_CHARSET));
        $this->assertEquals(self::UTF_CHARSET, $this->charset->get());
    }

    /**
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function test_must_throw_invalid_charset()
    {
        $this->charset->set(true);
    }

    /**
     * @test
     */
    public function test_is_supported_charset()
    {
        $this->assertTrue($this->charset->supported(self::UTF_CHARSET));
        $this->assertTrue($this->charset->supported(self::ISO_CHARSET));
        $this->assertTrue($this->charset->supported('utf-8'));
        $this->assertTrue($this->charset->supported('  UTF - 8  '));

        $this->assertFalse($this->charset->supported('WTF-8'));
    }

    /**
     * @test
     */
    public function test_can_get_default_if_not_supported()
    {
        $this->assertEquals('UTF-8', $this->charset->set('WTF-8')->get());
    }

    /**
     * @test
     */
    public function test_can_set_html_version()
    {
        $this->assertEquals('5', $this->charset->getVersion());

        $this->charset->setVersion('4');
        $this->assertEquals('4', $this->charset->getVersion());

        $this->charset->version(5);
        $this->assertEquals('5', $this->charset->version());
    }

    /**
     * @test
     *
     * @expectedException \Exception
     */
    public function test_must_throw_an_empty_html_version()
    {
        $this->charset->setVersion(' ');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidHTMLVersionException
     */
    public function test_must_throw_an_invalid_html_version()
    {
        $this->charset->setVersion('6');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function test_must_throw_an_invalid_type()
    {
        $this->charset->setVersion(true);
    }

    /**
     * @test
     */
    public function test_can_render_meta_tag()
    {
        $this->assertEquals('<meta charset="UTF-8">', $this->charset->render());

        $this->charset->setVersion(4);
        $this->assertEquals(
            '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">',
            $this->charset->render()
        );

        $this->charset->set('ISO-8859-15'); // Si vous savez ce que je veux dire
        $this->assertEquals(
            '<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">',
            $this->charset->render()
        );

        $this->charset->setVersion('5');
        $this->assertEquals(
            '<meta charset="ISO-8859-15">',
            $this->charset->render()
        );
    }

    /**
     * @test
     */
    public function test_has_default_charsets()
    {
        $method          = parent::getMethod('Charset', 'getDefaultCharsets');

        $defaultCharsets = $method->invoke($this->charset);

        $this->assertNotEmpty($defaultCharsets);
    }
}
