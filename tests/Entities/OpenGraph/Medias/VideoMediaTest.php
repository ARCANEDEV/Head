<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Entities\OpenGraph\Medias\VideoMedia;

/**
 * Class VideoMediaTest
 * @package Arcanedev\Head\Tests\Entities\OpenGraph\Medias
 */
class VideoMediaTest extends VisualMediaTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
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
    /** @test */
    public function test_can_be_instantiated()
    {
        $this->assertInstanceOf(VideoMedia::class, $this->media);
        $this->assertVisualMediaInstance();
        $this->assertAbstractMediaInstance();
    }

    /** @test */
    public function test_can_set_and_get_url()
    {
        $this->assertCanSetAndGetURL('http://www.company.com/video.mp4');

        $this->assertEquals('video/mp4', $this->media->getTypeFromUrl());
    }

    /** @test */
    public function test_can_set_and_get_secure_url()
    {
        $this->assertCanSetAndGetSecureURL('https://www.company.com/video.mp4');
    }

    /** @test */
    public function test_can_set_and_get_type()
    {
        $this->assertCanSetAndGetType('application/x-shockwave-flash');
    }

    /** @test */
    public function assert_can_set_and_get_width_and_height()
    {
        parent::assertCanSetAndGetWidthAndHeight();
    }

    /** @test */
    public function test_can_convert_extension_to_media_type()
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
