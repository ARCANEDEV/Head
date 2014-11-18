<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Entities\OpenGraph\Medias\VideoMedia;

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
    protected function setUp()
    {
        $this->media = new VideoMedia;
    }

    protected function tearDown()
    {
        unset($this->media);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function testCanInstantiate()
    {
        $this->assertInstanceOf('Arcanedev\\Head\\Entities\\OpenGraph\\Medias\\VideoMedia', $this->media);
        $this->assertVisualMediaInstance($this->media);
        $this->assertAbstractMediaInstance($this->media);
    }

    public function testCanSetAndGetURL($url = '')
    {
        parent::testCanSetAndGetURL('http://www.company.com/video.mp4');
    }

    public function testCanSetAndGetSecureURL($secureURL = '')
    {
        parent::testCanSetAndGetSecureURL('https://www.company.com/video.mp4');
    }

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
}
