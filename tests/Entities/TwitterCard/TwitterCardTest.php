<?php namespace Arcanedev\Head\Tests\Entities\TwitterCard;

use Arcanedev\Head\Entities\TwitterCard\TwitterCard;
use Arcanedev\Head\Tests\Entities\TestCase;

/**
 * Class TwitterCardTest
 * @package Arcanedev\Head\Tests\Entities\TwitterCard
 */
class TwitterCardTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var TwitterCard */
    private $twitterCard;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->twitterCard = new TwitterCard;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->twitterCard);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(TwitterCard::class, $this->twitterCard);
        $this->assertFalse($this->twitterCard->isEnabled());
        $this->assertEmpty($this->twitterCard->render());
    }

    /** @test */
    public function it_can_enable_and_disable()
    {
        $this->twitterCard->enable();

        $this->assertTrue($this->twitterCard->isEnabled());

        $this->twitterCard->disable();

        $this->assertFalse($this->twitterCard->isEnabled());
    }
}
