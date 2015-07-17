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
    private $card;

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
    }
}
