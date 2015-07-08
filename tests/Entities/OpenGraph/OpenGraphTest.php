<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph;

use Arcanedev\Head\Entities\OpenGraph\Medias\AudioMedia;
use Arcanedev\Head\Entities\OpenGraph\Medias\ImageMedia;
use Arcanedev\Head\Entities\OpenGraph\Medias\VideoMedia;
use Arcanedev\Head\Entities\OpenGraph\OpenGraph;
use Arcanedev\Head\Tests\Entities\TestCase;

/**
 * Class OpenGraphTest
 * @package Arcanedev\Head\Tests\Entities\OpenGraph
 */
class OpenGraphTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var OpenGraph */
    protected $og;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function setUp()
    {
        parent::setUp();

        $this->og = new OpenGraph;
    }

    protected function tearDown()
    {
        parent::tearDown();

        unset($this->og);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Function
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function test_can_be_instantiated()
    {
        $this->assertInstanceOf(OpenGraph::class, $this->og);
        // TODO: Add Countable to collections
        $this->assertFalse($this->og->isEnabled());
        $this->assertEquals(0, count($this->og->getImages()));
        $this->assertEquals(0, count($this->og->getVideos()));
        $this->assertEquals(0, count($this->og->getAudios()));
    }

    /** @test */
    public function test_can_set_and_get_type()
    {
        $type = 'website';
        $this->og->setType($type);

        $this->assertEquals($type, $this->og->getType());
    }

    /** @test */
    public function test_can_set_and_get_title()
    {
        $title = 'Hello World';
        $this->og->setTitle($title);

        $this->assertEquals($title, $this->og->getTitle());

        $title = 'This is the longest Hello world in the entire world, it is composed with multiple words and there is no need to wrap this Hello world.';
        $this->og->setTitle($title);
        $this->assertEquals(128, strlen($this->og->getTitle()));
    }

    /** @test */
    public function test_can_set_and_get_site_name()
    {
        $siteName = 'Company Name';
        $this->og->setSiteName($siteName);

        $this->assertEquals($siteName, $this->og->getSiteName());

        $siteName = 'This is the longest site name in the entire world, it is composed with multiple words and there is no need to wrap this site name.';
        $this->og->setSiteName($siteName);
        $this->assertEquals(128, strlen($this->og->getSiteName()));
    }

    /** @test */
    public function test_can_set_and_get_description()
    {
        $description = 'Hello world description';
        $this->og->setDescription($description);

        $this->assertEquals($description, $this->og->getDescription());

        $description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi architecto asperiores assumenda at distinctio dolor dolorem error exercitationem facilis in inventore, modi nisi nostrum odit porro quos repellendus rerum veniam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi architecto asperiores assumenda at distinctio dolor dolorem error exercitationem facilis in inventore, modi nisi nostrum odit porro quos repellendus rerum veniam.';
        $this->og->setDescription($description);
        $this->assertStringStartsWith('Lorem ipsum', $this->og->getDescription());
        $this->assertEquals(255, strlen($this->og->getDescription()));
    }

    /** @test */
    public function test_can_set_and_get_url()
    {
        $this->og->setURL('');
        $this->assertEmpty($this->og->getURL());

        $url = 'http://www.company.com';
        $this->og->setURL($url);

        $this->assertEquals($url, $this->og->getURL());

        $this->og->setURL('');
        $this->assertEquals($url, $this->og->getURL());
    }

    /** @test */
    public function test_can_set_and_get_determiner()
    {
        $determiner = 'the';
        $this->og->setDeterminer($determiner);

        $this->assertEquals($determiner, $this->og->getDeterminer());
    }

    /** @test */
    public function test_can_set_and_get_locale()
    {
        $locale = 'fr_FR';
        $this->og->setLocale($locale);

        $this->assertEquals($locale, $this->og->getLocale());
    }

    /** @test */
    public function test_can_enable_and_disable_open_graph()
    {
        $this->assertFalse($this->og->isEnabled());

        $this->og->enable();
        $this->assertTrue($this->og->isEnabled());

        $this->og->disable();
        $this->assertFalse($this->og->isEnabled());
    }

    /** @test */
    public function test_can_add_image()
    {
        $this->assertEquals(0, $this->og->imagesCount());

        $image = new ImageMedia();
        $image->setURL('http://example.com/image-1.jpg')
              ->setSecureURL('https://example.com/image-1.jpg')
              ->setType('image/jpeg')
              ->setWidth(400)
              ->setHeight(300);
        $this->og->addImage($image);

        $this->assertEquals(1, $this->og->imagesCount());

        $image = new ImageMedia();
        $image->setURL('http://example.com/image-2.jpg')
            ->setSecureURL('https://example.com/image-2.jpg')
            ->setType('image/jpeg')
            ->setWidth(400)
            ->setHeight(300);
        $this->og->addImage($image);

        $this->assertEquals(2, $this->og->imagesCount());
    }

    /** @test */
    public function test_can_add_video()
    {
        $this->assertEquals(0, $this->og->videosCount());

        $video = new VideoMedia();
        $video->setURL('http://example.com/video-1.swf')
              ->setSecureURL('https://example.com/video-1.swf')
              ->setType($video->getTypeFromUrl())
              ->setWidth(500)
              ->setHeight(400);
        $this->og->addVideo($video);

        $this->assertEquals(1, $this->og->videosCount());

        $video = new VideoMedia();
        $video->setURL('http://example.com/video-2.swf')
            ->setSecureURL('https://example.com/video-2.swf')
            ->setType($video->getTypeFromUrl())
            ->setWidth(500)
            ->setHeight(400);
        $this->og->addVideo($video);

        $this->assertEquals(2, $this->og->videosCount());
    }

    /** @test */
    public function test_can_not_add_video_without_url()
    {
        $this->assertEquals(0, $this->og->videosCount());

        $video = new VideoMedia;

        $this->og->addVideo($video);
        $this->assertEquals(0, $this->og->videosCount());
    }

    /** @test */
    public function test_can_add_audios()
    {
        $this->assertEquals(0, $this->og->audiosCount());

        $audio = new AudioMedia;
        $audio->setURL('http://example.com/audio-1.mp3')
              ->setSecureURL('https://example.com/audio-1.mp3')
              ->setType('audio/mpeg');
        $this->og->addAudio($audio);

        $this->assertEquals(1, $this->og->audiosCount());

        $audio = new AudioMedia;
        $audio->setURL('http://example.com/audio-2.mp3')
            ->setSecureURL('https://example.com/audio-2.mp3')
            ->setType('audio/mpeg');
        $this->og->addAudio($audio);

        $this->assertEquals(2, $this->og->audiosCount());
    }

    /** @test */
    public function test_can_not_add_audio_without_url()
    {
        $this->assertEquals(0, $this->og->audiosCount());

        $audio = new AudioMedia;

        $this->og->addAudio($audio);
        $this->assertEquals(0, $this->og->audiosCount());
    }

    /** @test */
    public function test_can_render()
    {
        $this->og->enable();
        $this->assertEquals('', $this->og->render());

        $type        = 'website';
        $title       = 'Hello World';
        $siteName    = 'Company Name';
        $description = "$title Description";
        $determiner  = 'the';
        $locale      = 'fr_FR';
        $url         = 'http://www.arcanedev.net';

        $this->og->setType($type)
            ->setTitle($title)
            ->setSiteName($siteName)
            ->setDescription($description)
            ->setURL($url)
            ->setDeterminer($determiner)
            ->setLocale($locale);

        $this->assertEquals(implode(PHP_EOL, [
            '<meta property="og:type" content="' . $type . '">',
            '<meta property="og:title" content="' . $title . '">',
            '<meta property="og:site_name" content="' . $siteName . '">',
            '<meta property="og:description" content="' . $description . '">',
            '<meta property="og:url" content="' . $url . '">',
            '<meta property="og:determiner" content="' . $determiner . '">',
            '<meta property="og:locale" content="' . $locale . '">',
        ]), $this->og->render());
    }

    /** @test */
    public function test_can_validate_url()
    {
        $this->assertEmpty(OpenGraph::isValidUrl(''));
        $this->assertEmpty(OpenGraph::isValidUrl('invalid-url'));
        $this->assertEmpty(OpenGraph::isValidUrl('http://invalid-url.org'));
        $this->assertEmpty(OpenGraph::isValidUrl('http://invalid-url.org?q=hello#home'));

        $url = 'https://www.facebook.com/arcanedev.agence.web.casablanca';
        $this->assertEquals($url, OpenGraph::isValidUrl($url));
    }

    /** @test */
    public function test_can_get_supported_types()
    {
        $this->assertEquals(8,  count(OpenGraph::supportedTypes()));
        $this->assertEquals(43, count(OpenGraph::supportedTypes(true)));
    }
}
