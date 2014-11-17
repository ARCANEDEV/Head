<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Keywords;

class KeywordsTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    protected $keywords;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function setUp()
    {
        $this->keywords = new Keywords;
    }

    protected function tearDown()
    {
        unset($this->keywords);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @test
     */
    public function testCanInstantiate()
    {
        $this->assertInstanceOf('Arcanedev\\Head\\Entities\\Keywords', $this->keywords);
    }
}
