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
    private $card;

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
    }
}
