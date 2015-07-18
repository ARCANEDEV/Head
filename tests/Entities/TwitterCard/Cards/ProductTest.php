<?php namespace Arcanedev\Head\Tests\Entities\TwitterCard\Cards;

use Arcanedev\Head\Entities\TwitterCard\Cards\Product;
use Arcanedev\Head\Tests\Entities\TwitterCard\TestCase;

/**
 * Class ProductTest
 * @package Arcanedev\Head\Tests\Entities\TwitterCard\Cards
 */
class ProductTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Product */
    protected $card;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->card = new Product;
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
        $this->assertInstanceOf(Product::class, $this->card);
        $this->assertEmpty($this->card->render());
        $this->assertEquals('product', $this->card->getType());
    }

    /** @test */
    public function it_can_set_and_get_site()
    {
        $username = '@Arcanedev';
        $this->card->setSite($username);

        $this->assertEquals($username, $this->card->getSite());
    }

    /** @test */
    public function it_can_set_and_get_creator()
    {
        $creator = 'Arcanedev';
        $this->card->setCreator($creator);

        $this->assertEquals('@' . $creator, $this->card->getCreator());
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
    public function it_can_set_and_get_data1()
    {
        $data1 = 'Deep House';
        $this->card->setData1($data1);

        $this->assertEquals($data1, $this->card->getData1());
    }

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The product's data1 is required.
     */
    public function it_must_throw_invalid_argument_on_empty_data1()
    {
        $this->card->setData1('');
    }

    /** @test */
    public function it_can_set_and_get_label1()
    {
        $label1 = 'C2C';
        $this->card->setLabel1($label1);

        $this->assertEquals($label1, $this->card->getLabel1());
    }

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The product's label1 is required.
     */
    public function it_must_throw_invalid_argument_on_empty_label1()
    {
        $this->card->setLabel1('');
    }

    /** @test */
    public function it_can_set_and_get_data2()
    {
        $data2 = 'Indie';
        $this->card->setData2($data2);

        $this->assertEquals($data2, $this->card->getData2());
    }

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The product's data2 is required.
     */
    public function it_must_throw_invalid_argument_on_empty_data2()
    {
        $this->card->setData2('');
    }

    /** @test */
    public function it_can_set_and_get_label2()
    {
        $label2 = 'Alt-J';
        $this->card->setLabel2($label2);

        $this->assertEquals($label2, $this->card->getLabel2());
    }

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The product's label2 is required.
     */
    public function it_must_throw_invalid_argument_on_empty_label2()
    {
        $this->card->setLabel2('');
    }

    /** @test */
    public function it_can_render()
    {
        $username    = 'Arcanedev';
        $title       = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $image       = 'http://www.arcanedev.net/uploads/images/posts/thumbs/default/welcome-to-arcanedev.jpg';
        $data1       = 'Deep House';
        $label1      = 'C2C';
        $data2       = 'Indie';
        $label2      = 'Alt-J';

        $this->card->setSite($username);
        $this->card->setCreator($username);
        $this->card->setTitle($title);
        $this->card->setDescription($description);
        $this->card->setImage($image);
        $this->card->setData1($data1);
        $this->card->setLabel1($label1);
        $this->card->setData2($data2);
        $this->card->setLabel2($label2);

        $tags = $this->generateTags([
            'card'        => 'product',
            'site'        => '@' . $username,
            'creator'     => '@' . $username,
            'title'       => $title,
            'description' => $description,
            'image'       => $image,
            'data1'       => $data1,
            'label1'      => $label1,
            'data2'       => $data2,
            'label2'      => $label2,
        ]);

        $this->assertEquals($tags, $this->card->render());
    }
}
