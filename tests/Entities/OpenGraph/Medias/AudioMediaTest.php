<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Entities\OpenGraph\Medias\AudioMedia;

class AudioMediaTest extends AbstractMediaTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const OG_AUDIO_MEDIA_CLASS = 'Arcanedev\\Head\\Entities\\OpenGraph\\Medias\\AudioMedia';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
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
    public function test_can_be_instantiated()
    {
        $this->assertInstanceOf(self::OG_AUDIO_MEDIA_CLASS, $this->media);
        $this->assertAbstractMediaInstance();
    }

    /**
     * @test
     */
    public function test_can_set_and_get_url()
    {
        $this->assertCanSetAndGetURL('http://www.company.com/audio.mp3');
    }

    /**
     * @test
     */
    public function test_can_set_and_get_secure_url()
    {
        $this->assertCanSetAndGetSecureURL('https://www.company.com/audio.mp3');
    }

    /**
     * @test
     */
    public function test_can_set_and_get_type()
    {
        $this->assertCanSetAndGetType('audio/mpeg');
    }

    /**
     * @test
     */
    public function test_can_convert_extension_to_media_type()
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
