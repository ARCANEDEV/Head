<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Entities\OpenGraph\Medias\VideoMedia;

class VideoMediaTest extends VisualMediaTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const OPENGRAPH_VIDEOMEDIA_CLASS = 'Arcanedev\\Head\\Entities\\OpenGraph\\Medias\\VideoMedia';
    /** @var VideoMedia */
    protected $media;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->media = new VideoMedia;
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
    /**
     * @test
     */
    public function testCanInstantiate()
    {
        $this->assertInstanceOf(self::OPENGRAPH_VIDEOMEDIA_CLASS, $this->media);
        $this->assertVisualMediaInstance();
        $this->assertAbstractMediaInstance();
    }

    /**
     * @test
     */
    public function testCanSetAndGetURL($url = '')
    {
        parent::testCanSetAndGetURL('http://www.company.com/video.mp4');

        $this->assertEquals('video/mp4', $this->media->getTypeFromUrl());
    }

    /**
     * @test
     */
    public function testCanSetAndGetSecureURL($secureURL = '')
    {
        parent::testCanSetAndGetSecureURL('https://www.company.com/video.mp4');
    }

    /**
     * @test
     */
    public function testCanSetAndGetType($type = '')
    {
        parent::testCanSetAndGetType('application/x-shockwave-flash');
    }

    /**
     * @test
     */
    public function assertCanSetAndGetWidthAndHeight()
    {
        parent::assertCanSetAndGetWidthAndHeight();
    }

    /**
     * @test
     */
    public function testCanConvertExtensionToMediaType()
    {
        $extensions = [
            'swf'   => 'application/x-shockwave-flash',
            'mp4'   => 'video/mp4',
            'ogv'   => 'video/ogg',
            'webm'  => 'video/webm',
            'lol'   => '',
            true    => '',
        ];

        foreach ($extensions as $ext => $type) {
            $this->assertEquals($type, VideoMedia::extensionToMediaType($ext));
        }
    }
}
