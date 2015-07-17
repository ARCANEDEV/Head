<?php namespace Arcanedev\Head\Tests\Entities\TwitterCard\Cards;

use Arcanedev\Head\Entities\TwitterCard\Cards\SummaryLargeImage;
use Arcanedev\Head\Tests\Entities\TestCase;

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
    }
}
