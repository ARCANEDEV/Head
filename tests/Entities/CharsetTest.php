<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Tests\TestCase;

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
        $getDefaultCharsetsMethd = $this->getMethod('Entities\\Charset', 'getDefaultCharsets');

        $getDefaultCharsets = function_exists('mb_list_encodings')
            ? mb_list_encodings()
            : $this->getDefaultCharsets();

        $this->assertEquals($getDefaultCharsets, $getDefaultCharsetsMethd->invoke($this->charset));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    private function getDefaultCharsets()
    {
        return [
            'pass', 'auto', 'wchar', 'byte2be', 'byte2le', 'byte4be', 'byte4le', 'BASE64', 'UUENCODE', 'HTML-ENTITIES',
            'Quoted-Printable', '7bit', '8bit', 'UCS-4', 'UCS-4BE', 'UCS-4LE', 'UCS-2', 'UCS-2BE', 'UCS-2LE', 'UTF-32',
            'UTF-32BE', 'UTF-32LE', 'UTF-16', 'UTF-16BE', 'UTF-16LE', 'UTF-8', 'UTF-7', 'UTF7-IMAP', 'ASCII', 'EUC-JP',
            'SJIS', 'eucJP-win', 'EUC-JP-2004', 'SJIS-win', 'SJIS-Mobile#DOCOMO', 'SJIS-Mobile#KDDI', 'SJIS-Mobile#SOFTBANK',
            'SJIS-mac', 'SJIS-2004', 'UTF-8-Mobile#DOCOMO', 'UTF-8-Mobile#KDDI-A', 'UTF-8-Mobile#KDDI-B', 'UTF-8-Mobile#SOFTBANK',
            'CP932', 'CP51932', 'JIS', 'ISO-2022-JP', 'ISO-2022-JP-MS', 'GB18030', 'Windows-1252', 'Windows-1254',
            'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5', 'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8',
            'ISO-8859-9', 'ISO-8859-10', 'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16', 'EUC-CN', 'CP936',
            'HZ', 'EUC-TW', 'BIG-5', 'CP950', 'EUC-KR', 'UHC', 'ISO-2022-KR', 'Windows-1251', 'CP866', 'KOI8-R', 'KOI8-U',
            'ArmSCII-8', 'CP850', 'JIS-ms', 'ISO-2022-JP-2004', 'ISO-2022-JP-MOBILE#KDDI', 'CP50220', 'CP50220raw', 'CP50221',
            'CP50222',
        ];
    }
}
