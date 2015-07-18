<?php namespace Arcanedev\Head\Tests\Entities\TwitterCard\Cards;

use Arcanedev\Head\Entities\TwitterCard\Cards\Gallery;
use Arcanedev\Head\Tests\Entities\TwitterCard\TestCase;

/**
 * Class GalleryTest
 * @package Arcanedev\Head\Tests\Entities\TwitterCard\Cards
 */
class GalleryTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Gallery */
    protected $card;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->card = new Gallery;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->card);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Gallery::class, $this->card);
        $this->assertEmpty($this->card->render());
        $this->assertEquals('gallery', $this->card->getType());
    }

    /** @test */
    public function it_can_set_and_get_creator()
    {
        $creator = 'Arcanedev';

        $this->card->setCreator($creator);

        $this->assertEquals('@' . $creator, $this->card->getCreator());
    }

    /** @test */
    public function it_can_set_and_get_description()
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $this->card->setDescription($description);

        $this->assertEquals($description, $this->card->getDescription());

        $description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
        $this->card->setDescription($description);
        $description = str_limit($description, 200 - strlen('...'), '...');

        $this->assertEquals($description, $this->card->getDescription());
    }

    /** @test */
    public function it_can_set_and_get_url()
    {
        $url = 'https://www.facebook.com/arcanedev.agence.web.casablanca/photos_stream';
        $this->card->setUrl($url);

        $this->assertEquals($url, $this->card->getUrl());
    }

    /** @test */
    public function it_can_set_and_get_image_0()
    {
        $image = 'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg';
        $this->card->setImage0($image);

        $this->assertEquals($image, $this->card->getImage0());
    }

    /** @test */
    public function it_can_set_and_get_image_1()
    {
        $image = 'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg';
        $this->card->setImage1($image);

        $this->assertEquals($image, $this->card->getImage1());
    }

    /** @test */
    public function it_can_set_and_get_image_2()
    {
        $image = 'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg';
        $this->card->setImage2($image);

        $this->assertEquals($image, $this->card->getImage2());
    }

    /** @test */
    public function it_can_set_and_get_image_3()
    {
        $image = 'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg';
        $this->card->setImage3($image);

        $this->assertEquals($image, $this->card->getImage3());
    }

    /** @test */
    public function it_can_set_and_get_multiple_images()
    {
        $images = [
            'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg',
            'http://www.arcanedev.net/assets/img/arcanedev-responsive.png',
            'http://www.arcanedev.net/assets/img/slider/5/mac.png',
            'http://www.arcanedev.net/assets/img/slider/5/macbook.png',
        ];

        $this->card->setImages($images);

        $this->assertCount(4, $this->card->getImages());
        $this->assertEquals($images, $this->card->getImages());
    }

    /** @test */
    public function it_can_set_and_get_multiple_images_with_limit()
    {
        $images = [
            'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg',
            'http://www.arcanedev.net/assets/img/arcanedev-responsive.png',
            'http://www.arcanedev.net/assets/img/slider/5/mac.png',
            'http://www.arcanedev.net/assets/img/slider/5/macbook.png',

            'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg',
            'http://www.arcanedev.net/assets/img/arcanedev-responsive.png',
            'http://www.arcanedev.net/assets/img/slider/5/mac.png',
            'http://www.arcanedev.net/assets/img/slider/5/macbook.png',
        ];

        $this->card->setImages($images);

        $this->assertCount(4, $this->card->getImages());
        $this->assertEquals(array_slice($images, 0, 4), $this->card->getImages());
    }

    /** @test */
    public function it_can_render()
    {
        $username    = 'Arcanedev';
        $title       = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $url         = 'https://www.facebook.com/arcanedev.agence.web.casablanca/photos_stream';
        $images      = [
            'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg',
            'http://www.arcanedev.net/assets/img/arcanedev-responsive.png',
            'http://www.arcanedev.net/assets/img/slider/5/mac.png',
            'http://www.arcanedev.net/assets/img/slider/5/macbook.png',
        ];

        $this->card->setSite($username);
        $this->card->setCreator($username);
        $this->card->setTitle($title);
        $this->card->setDescription($description);
        $this->card->setUrl($url);
        $this->card->setImages($images);

        $tags = $this->generateTags([
            'card'        => 'gallery',
            'site'        => '@' . $username,
            'creator'     => '@' . $username,
            'title'       => $title,
            'description' => $description,
            'url'         => $url,
            'image0'      => $images[0],
            'image1'      => $images[1],
            'image2'      => $images[2],
            'image3'      => $images[3],
        ]);

        $this->assertEquals($tags, $this->card->render());
    }
}
