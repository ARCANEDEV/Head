<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Charset;

class CharsetTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Charset */
    protected $charset;

    const FIRST_CHARSET     = 'UTF-8';
    const SECOND_CHARSET    = 'ISO-8859-15';

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
    public function testCanInstantiate()
    {
        $this->assertInstanceOf('Arcanedev\\Head\\Entities\\Charset', $this->charset);
    }

    /**
     * @test
     */
    public function testCanSetAndGetCharset()
    {
        $this->assertEquals(self::FIRST_CHARSET, $this->charset->get());
        $this->assertEquals(self::SECOND_CHARSET, $this->charset->set(self::SECOND_CHARSET)->get());
        $this->assertEquals(self::FIRST_CHARSET, $this->charset->set('utf-8')->get());
    }

    /**
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMostThrowInvalidCharset()
    {
        $this->charset->set(true);
    }

    /**
     * @test
     */
    public function testIfCharsetIsSupported()
    {
        $this->assertTrue($this->charset->supported(self::FIRST_CHARSET));
        $this->assertTrue($this->charset->supported(self::SECOND_CHARSET));
        $this->assertTrue($this->charset->supported('utf-8'));
        $this->assertTrue($this->charset->supported('  UTF - 8  '));
    }

    /**
     * @test
     */
    public function testIfCharsetIsNotSupported()
    {
        $this->assertFalse($this->charset->supported('WTF-8'));
    }

    /**
     * @test
     */
    public function testCanGetDefaultIfNotSupported()
    {
        $this->assertEquals('UTF-8', $this->charset->set('WTF-8')->get());
    }

    /**
     * @test
     */
    public function testCanSetHTMLVersion()
    {
        $this->assertEquals('5', $this->charset->getVersion());

        $this->charset->setVersion('4');
        $this->assertEquals('4', $this->charset->getVersion());

        $this->assertEquals('5', $this->charset->version(5)->version());
    }

    /**
     * @test
     *
     * @expectedException \Exception
     */
    public function testMustThrowAnEmptyHTMLVersion()
    {
        $this->charset->setVersion(' ');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidHTMLVersionException
     */
    public function testMustThrowAnInvalidHTMLVersion()
    {
        $this->charset->setVersion('6');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowAnInvalidType()
    {
        $this->charset->setVersion(true);
    }

    /**
     * @test
     */
    public function testCanRenderMetaTag()
    {
        $this->assertEquals('<meta charset="UTF-8">', $this->charset->render());

        $this->charset->setVersion(4);
        $this->assertEquals('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">', $this->charset->render());

        $this->charset->set('ISO-8859-15'); // Si vous savez ce que je veux dire
        $this->assertEquals('<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">', $this->charset->render());

        $this->charset->setVersion('5');
        $this->assertEquals('<meta charset="ISO-8859-15">', $this->charset->render());
    }

    public function testHasDefaultCharsets()
    {
        $method             = parent::getMethod('Charset', 'getDefaultCharsets');

        $defaultCharsets    = $method->invoke($this->charset);

        $this->assertNotEmpty($defaultCharsets);
    }
}
