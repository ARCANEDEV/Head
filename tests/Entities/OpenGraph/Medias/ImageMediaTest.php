<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Entities\OpenGraph\Medias\ImageMedia;

/**
 * Class ImageMediaTest
 * @package Arcanedev\Head\Tests\Entities\OpenGraph\Medias
 */
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
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(ImageMedia::class, $this->media);
        $this->assertVisualMediaInstance();
        $this->assertAbstractMediaInstance();
    }

    /** @test */
    public function it_can_set_and_get_url()
    {
        $url = 'http://www.company.com/image.jpg';

        $this->assertCanSetAndGetURL($url);

        $this->assertEquals($url, $this->media->toString());

        $this->media->removeURL();

        $this->assertEquals('', $this->media->getURL());
        $this->assertEquals('', $this->media->toString());
    }

    /** @test */
    public function it_can_set_and_get_secure_url()
    {
        $this->assertCanSetAndGetSecureURL('https://www.company.com/image.jpg');
    }

    /** @test */
    public function it_can_set_and_get_type()
    {
        $this->assertCanSetAndGetType('image/jpeg');
    }

    /** @test */
    public function it_can_set_and_get_width_and_height()
    {
        $this->assertCanSetAndGetWidthAndHeight();
    }

    /** @test */
    public function it_can_convert_extension_to_media_type()
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

    /** @test */
    public function it_can_convert_to_array()
    {
        $height    = 120;
        $width     = 120;
        $url       = 'http://www.company.com/image.jpg';
        $secureUrl = 'https://www.company.com/image.jpg';
        $type      = 'image/jpeg';

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
