<?php namespace Arcanedev\Head\Tests\Entities\TwitterCard\Cards;

use Arcanedev\Head\Entities\TwitterCard\Cards\App;
use Arcanedev\Head\Tests\Entities\TwitterCard\TestCase;

/**
 * Class AppTest
 * @package Arcanedev\Head\Tests\Entities\TwitterCard\Cards
 */
class AppTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var App */
    protected $card;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->card = new App;
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
        $this->assertInstanceOf(App::class, $this->card);
        $this->assertEmpty($this->card->render());
        $this->assertEquals('app', $this->card->getType());
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
    public function it_can_get_and_set_app()
    {
        $app = [
            'id' => [
                'iphone'     => '307234931',
                'ipad'       => '307234931',
                'googleplay' => 'com.android.app',
            ],
        ];
        $this->card->setApp($app);

        $this->assertCount(3, $this->card->getApp()['id']);
        foreach($app['id'] as $key => $value) {
            $this->assertArrayHasKey($key, $this->card->getApp()['id']);
        }
    }

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The app must provide the ids.
     */
    public function it_must_throw_invalid_argument_exception_on_missing_id_key()
    {
        $this->card->setApp([
            'url' => [
                'iphone'    => 'cannonball://poem/5149e249222f9e600a7540ef'
            ]
        ]);
    }

    /**
     * @test
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The app must provide the ids for [ipad, googleplay].
     */
    public function it_must_throw_invalid_argument_exception_on_missing_id()
    {
        $this->card->setApp([
            'id' => [
                'iphone'     => '307234931',
            ],
        ]);
    }

    /** @test */
    public function it_can_render()
    {
        $username    = 'Arcanedev';
        $description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
        $app         = [
            'id' => [
                'iphone'     => '307234931',
                'ipad'       => '307234931',
                'googleplay' => 'com.android.app',
            ],
        ];

        $this->card->setSite($username);
        $this->card->setDescription($description);
        $this->card->setApp($app);

        $tags = $this->generateTags([
            'card'        => 'app',
            'site'        => '@' . $username,
            'description' => $description,
            'app'         => $app
        ]);

        $this->assertEquals($tags, $this->card->render());
    }
}
