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

    const OG_IMAGEMEDIA_CLASS = 'Arcanedev\\Head\\Entities\\OpenGraph\\Medias\\ImageMedia';

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
        $this->assertInstanceOf(
            self::OG_IMAGEMEDIA_CLASS,
            $this->media
        );
        $this->assertVisualMediaInstance();
        $this->assertAbstractMediaInstance();
    }

    /**
     * @test
     */
    public function testCanSetAndGetURL($url = '')
    {
        $url = "http://www.company.com/image.jpg";

        parent::testCanSetAndGetURL($url);

        $this->assertEquals($url, $this->media->toString());

        $this->media->removeURL();

        $this->assertEquals('', $this->media->getURL());
        $this->assertEquals('', $this->media->toString());
    }

    /**
     * @test
     */
    public function testCanSetAndGetSecureURL($secureURL = '')
    {
        $secureURL = "https://www.company.com/image.jpg";

        parent::testCanSetAndGetSecureURL($secureURL);
    }

    /**
     * @test
     */
    public function testCanSetAndGetType($type = '')
    {
        $type = 'image/jpeg';

        parent::testCanSetAndGetType($type);
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

    /**
     * @test
     */
    public function testCanConvertToArray()
    {
        $height    = 120;
        $width     = 120;
        $url       = "http://www.company.com/image.jpg";
        $secureUrl = "https://www.company.com/image.jpg";
        $type      = "image/jpeg";

        $this->media->setURL($url)->setSecureURL($secureUrl)
                    ->setHeight($height)->setWidth($width)
                    ->setType($type);

        $array = [
            'height'    => $height,
            'width'     => $width,
            'url'       => $url,
            'secureUrl' => $secureUrl,
            'type'      => $type,
        ];

        $this->assertEquals($array, $this->media->toArray());
    }
}
