<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Entities\OpenGraph\Medias\ImageMedia;

class ImageMediaTest extends VisualMediaTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const OPENGRAPH_IMAGEMEDIA_CLASS = 'Arcanedev\\Head\\Entities\\OpenGraph\\Medias\\ImageMedia';
    /** @var ImageMedia */
    protected $media;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->media = new ImageMedia;
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
        $this->assertInstanceOf(self::OPENGRAPH_IMAGEMEDIA_CLASS, $this->media);
        $this->assertVisualMediaInstance();
        $this->assertAbstractMediaInstance();
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

    /**
     * @test
     */
    public function testCanConvertExtensionToMediaType()
    {
        $extensions = [
            'jpeg'  => 'image/jpeg',
            'jpg'   => 'image/jpeg',
            'png'   => 'image/png',
            'gif'   => 'image/gif',
            'svg'   => 'image/svg+sml',
            'ico'   => 'image/vnd.microsoft.icon',
            'lol'   => null,
            true    => null
        ];

        foreach ($extensions as $ext => $type) {
            $this->assertEquals($type, ImageMedia::extensionToMediaType($ext));
        }
    }
}
