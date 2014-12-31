<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Entities\OpenGraph\Medias\AudioMedia;

class AudioMediaTest extends AbstractMediaTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const OPENGRAPH_AUDIOMEDIA_CLASS = 'Arcanedev\\Head\\Entities\\OpenGraph\\Medias\\AudioMedia';
    /** @var AudioMedia */
    protected $media;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->media = new AudioMedia;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->media);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function testCanInstantiate()
    {
        $this->assertInstanceOf(self::OPENGRAPH_AUDIOMEDIA_CLASS, $this->media);
        $this->assertAbstractMediaInstance();
    }

    /**
     * @test
     */
    public function testCanSetAndGetURL($url = '')
    {
        parent::testCanSetAndGetURL('http://www.company.com/audio.mp3');
    }

    /**
     * @test
     */
    public function testCanSetAndGetSecureURL($secureURL = '')
    {
        parent::testCanSetAndGetSecureURL('https://www.company.com/audio.mp3');
    }

    /**
     * @test
     */
    public function testCanSetAndGetType($type = '')
    {
        parent::testCanSetAndGetType('audio/mpeg');
    }

    /**
     * @test
     */
    public function testCanConvertExtensionToMediaType()
    {
        $extensions = [
            'swf'   => 'application/x-shockwave-flash',
            'mp3'   => 'audio/mpeg',
            'm4a'   => 'audio/mp4',
            'ogg'   => 'audio/ogg',
            'oga'   => 'audio/ogg',
            'lol'   => '',
            true    => ''
        ];

        foreach ($extensions as $ext => $type) {
            $this->assertEquals($type, AudioMedia::extensionToMediaType($ext));
        }
    }
}
