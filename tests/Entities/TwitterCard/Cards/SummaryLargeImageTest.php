<?php namespace Arcanedev\Head\Tests\Entities\TwitterCard\Cards;

use Arcanedev\Head\Entities\TwitterCard\Cards\SummaryLargeImage;
use Arcanedev\Head\Tests\Entities\TwitterCard\TestCase;

/**
 * Class SummaryLargeImageTest
 * @package Arcanedev\Head\Tests\Entities\TwitterCard\Cards
 */
class SummaryLargeImageTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var SummaryLargeImage */
    private $card;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->card = new SummaryLargeImage;
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
        $this->assertInstanceOf(SummaryLargeImage::class, $this->card);
        $this->assertEmpty($this->card->render());
        $this->assertEquals('summary_large_image', $this->card->getType());
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

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The description attribute must not be empty.
     */
    public function it_must_throw_invalid_argument_exception_on_empty_description()
    {
        $this->card->setDescription('');
    }

    /** @test */
    public function it_can_set_and_get_image()
    {
        $image = 'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg';

        $this->card->setImage($image);

        $this->assertEquals($image, $this->card->getImage());
    }

    /** @test */
    public function it_can_render()
    {
        $username    = 'Arcanedev';
        $title       = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';

        $this->card->setSite($username);
        $this->card->setCreator($username);
        $this->card->setTitle($title);
        $this->card->setDescription($description);

        $tags = $this->generateTags([
            'card'        => 'summary_large_image',
            'site'        => '@' . $username,
            'creator'     => '@' . $username,
            'title'       => $title,
            'description' => $description,
        ]);

        $this->assertEquals($tags, $this->card->render());
    }
}
