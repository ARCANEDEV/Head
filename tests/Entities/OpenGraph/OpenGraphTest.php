<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph;

use Arcanedev\Head\Tests\Entities\TestCase;

use Arcanedev\Head\Entities\OpenGraph\OpenGraph;
use Arcanedev\Head\Entities\OpenGraph\Medias\AudioMedia;
use Arcanedev\Head\Entities\OpenGraph\Medias\ImageMedia;
use Arcanedev\Head\Entities\OpenGraph\Medias\VideoMedia;

class OpenGraphTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var OpenGraph */
    protected $og;

    const OPENGRAPH_CLASS = 'Arcanedev\\Head\\Entities\\OpenGraph\\OpenGraph';

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
    /**
     * @test
     */
    public function testCanInstantiate()
    {
        $this->assertInstanceOf(self::OPENGRAPH_CLASS, $this->og);
        // TODO: Add Countable to collections
        $this->assertEquals(0, count($this->og->getImages()));
        $this->assertEquals(0, count($this->og->getVideos()));
        $this->assertEquals(0, count($this->og->getAudios()));
    }

    /**
     * @test
     */
    public function testCanSetAndGetType()
    {
        $type = 'website';
        $this->og->setType($type);

        $this->assertEquals($type, $this->og->getType());
    }

    /**
     * @test
     */
    public function testCanSetAndGetTitle()
    {
        $title = 'Hello World';
        $this->og->setTitle($title);

        $this->assertEquals($title, $this->og->getTitle());
    }

    /**
     * @test
     */
    public function testCanSetAndGetSiteName()
    {
        $siteName = 'Company Name';
        $this->og->setSiteName($siteName);

        $this->assertEquals($siteName, $this->og->getSiteName());
    }

    /**
     * @test
     */
    public function testCanSetAndGetURL()
    {
        $url = 'http://www.company.com';
        $this->og->setURL($url);

        $this->assertEquals($url, $this->og->getURL());
    }

    /**
     * @test
     */
    public function testCanSetAndGetDeterminer()
    {
        $determiner = 'the';
        $this->og->setDeterminer($determiner);

        $this->assertEquals($determiner, $this->og->getDeterminer());
    }

    /**
     * @test
     */
    public function testCanSetAndGetLocale()
    {
        $locale = 'fr_FR';
        $this->og->setLocale($locale);

        $this->assertEquals($locale, $this->og->getLocale());
    }

    public function testCanAddImage()
    {
        $image = new ImageMedia();
        $image->setURL('http://example.com/image-1.jpg')
            ->setSecureURL('https://example.com/image-1.jpg')
            ->setType('image/jpeg')
            ->setWidth(400)
            ->setHeight(300);

        $this->og->addImage($image);

        $this->assertEquals(1, count($this->og->getImages()));
    }

    public function testCanAddVideo()
    {
        $video = new VideoMedia();
        $video->setURL('http://example.com/video.swf')
            ->setSecureURL('https://example.com/video.swf')
            ->setType($video->getTypeFromUrl())
            ->setWidth(500)
            ->setHeight(400);

        $this->og->addVideo($video);

        $this->assertCount(1, $this->og->getVideos());
    }

    /**
     * @test
     */
    public function testCanAddAudio()
    {
        $audio = new AudioMedia;
        $audio->setURL('http://example.com/audio.mp3')
              ->setSecureURL('https://example.com/audio.mp3')
              ->setType('audio/mpeg');

        $this->og->addAudio($audio);
    }
}
