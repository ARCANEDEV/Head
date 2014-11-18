<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Entities\OpenGraph\Medias\ImageMedia;

class ImageMediaTest extends VisualMediaTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var ImageMedia */
    protected $media;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function setUp()
    {
        $this->media = new ImageMedia;
    }

    protected function tearDown()
    {
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
        $this->assertInstanceOf('Arcanedev\\Head\\Entities\\OpenGraph\\Medias\\ImageMedia', $this->media);
        $this->assertVisualMediaInstance($this->media);
        $this->assertAbstractMediaInstance($this->media);
    }

    /**
     * @test
     */
    public function testCanSetAndGetURL($url = '')
    {
        parent::testCanSetAndGetURL('http://www.company.com/image.jpg');
    }

    /**
     * @test
     */
    public function testCanSetAndGetSecureURL($secureURL = '')
    {
        parent::testCanSetAndGetSecureURL("https://www.company.com/image.jpg");
    }

    /**
     * @test
     */
    public function testCanSetAndGetType($type = '')
    {
        parent::testCanSetAndGetType('image/jpeg');
    }

    /**
     * @test
     */
    public function assertCanSetAndGetWidthAndHeight()
    {
        parent::assertCanSetAndGetWidthAndHeight();
    }
}
