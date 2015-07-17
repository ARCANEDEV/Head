<?php namespace Arcanedev\Head\Tests\Entities\TwitterCard\Cards;

use Arcanedev\Head\Entities\TwitterCard\Cards\Summary;
use Arcanedev\Head\Tests\Entities\TestCase;

/**
 * Class SummaryTest
 * @package Arcanedev\Head\Tests\Entities\TwitterCard\Cards
 */
class SummaryTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Summary */
    private $card;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->card = new Summary;
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
        $this->assertInstanceOf(Summary::class, $this->card);
        $this->assertEmpty($this->card->render());
        $this->assertEquals('summary', $this->card->getType());
    }

    /** @test */
    public function it_can_set_and_get_site()
    {
        $username = '@Arcanedev';
        $this->card->setSite($username);

        $this->assertEquals($username, $this->card->getSite());
    }

    /** @test */
    public function it_can_set_and_get_site_by_adding_the_at_symbol()
    {
        $username = 'Github';
        $this->card->setSite($username);

        $this->assertEquals('@' . $username, $this->card->getSite());
    }

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The site attribute must not be empty.
     */
    public function it_must_throw_invalid_argument_exception_on_empty_site()
    {
        $this->card->setSite('');
    }

    /** @test */
    public function it_can_set_and_get_title()
    {
        $title = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $this->card->setTitle($title);

        $this->assertEquals($title, $this->card->getTitle());

        $title = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
        $this->card->setTitle($title);
        $title = str_limit($title, 70 - strlen('...'), '...');

        $this->assertEquals($title, $this->card->getTitle());
    }

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The title attribute must not be empty.
     */
    public function it_must_throw_invalid_argument_exception_on_empty_title()
    {
        $this->card->setTitle('');
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
        $this->card->setTitle($title);
        $this->card->setDescription($description);

        $tags = $this->generateTags([
            'card'        => 'summary',
            'site'        => '@' . $username,
            'title'       => $title,
            'description' => $description,
        ]);

        $this->assertEquals($tags, $this->card->render());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Generate twitter card tags
     *
     * @param  array $tags
     *
     * @return string
     */
    private function generateTags(array $tags)
    {
        $result = [];

        foreach ($tags as $name => $content) {
            $result[] = "<meta name=\"twitter:$name\" content=\"$content\">";
        }

        return implode(PHP_EOL, $result);
    }
}
