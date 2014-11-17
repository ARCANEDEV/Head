<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Tests\TestCase;

use Arcanedev\Head\Entities\Description;

class DescriptionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    protected $description;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function setUp()
    {
        $this->description = new Description;
    }

    protected function tearDown()
    {
        unset($this->description);
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
        $this->assertInstanceOf('Arcanedev\\Head\\Entities\\Description', $this->description);
    }
}
