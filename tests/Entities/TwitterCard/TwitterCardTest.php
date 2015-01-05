<?php namespace Arcanedev\Head\Tests\Entities\TwitterCard;

use Arcanedev\Head\Entities\TwitterCard\TwitterCard;
use Arcanedev\Head\Tests\Entities\TestCase;

class TwitterCardTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const TWITTER_CARD_CLASS = 'Arcanedev\\Head\\Entities\\TwitterCard\\TwitterCard';
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
    /**
     * @test
     */
    public function testCanBeInstantiated()
    {
        $this->assertInstanceOf(self::TWITTER_CARD_CLASS, $this->twitterCard);
    }
}
