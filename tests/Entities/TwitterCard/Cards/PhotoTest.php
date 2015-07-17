<?php namespace Arcanedev\Head\Tests\Entities\TwitterCard\Cards;

use Arcanedev\Head\Entities\TwitterCard\Cards\Photo;
use Arcanedev\Head\Tests\Entities\TwitterCard\TestCase;

/**
 * Class PhotoTest
 * @package Arcanedev\Head\Tests\Entities\TwitterCard\Cards
 */
class PhotoTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Photo */
    protected $card;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->card = new Photo;
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
        $this->assertInstanceOf(Photo::class, $this->card);
        $this->assertEmpty($this->card->render());
        $this->assertEquals('photo', $this->card->getType());
    }

    /** @test */
    public function it_can_set_and_get_creator()
    {
        $creator = 'Arcanedev';

        $this->card->setCreator($creator);

        $this->assertEquals('@' . $creator, $this->card->getCreator());
    }

    /** @test */
    public function it_can_set_and_get_image()
    {
        $image = 'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg';

        $this->card->setImage($image);

        $this->assertEquals($image, $this->card->getImage());
    }

    /** @test */
    public function it_can_set_and_get_url()
    {
        $url = 'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg';

        $this->card->setUrl($url);

        $this->assertEquals($url, $this->card->getUrl());
    }

    /** @test */
    public function it_can_render()
    {
        $username    = 'Arcanedev';
        $title       = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $image       = 'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg';

        $this->card->setSite($username);
        $this->card->setCreator($username);
        $this->card->setTitle($title);
        $this->card->setImage($image);
        $this->card->setUrl($image);

        $tags = $this->generateTags([
            'card'        => 'photo',
            'site'        => '@' . $username,
            'creator'     => '@' . $username,
            'title'       => $title,
            'image'       => $image,
            'url'         => $image,
        ]);

        $this->assertEquals($tags, $this->card->render());
    }
}
