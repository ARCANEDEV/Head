<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Description;

/**
 * Class DescriptionTest
 * @package Arcanedev\Head\Tests\Entities
 */
class DescriptionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Description */
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
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Description::class, $this->description);
        $this->assertTrue($this->description->isEmpty());
        $this->assertEmpty($this->description->render());
    }

    /** @test */
    public function it_can_set_and_get_description()
    {
        $this->assertEquals('', $this->description->get());

        $description = 'Hello world description';
        $this->description->set($description);

        $this->assertEquals($description, $this->description->get());
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function it_must_throw_invalid_type_exception()
    {
        $this->description->set(true);
    }

    /** @test */
    public function it_can_render()
    {
        $this->assertEquals('', $this->description->render());

        $description = 'Hello world description';
        $this->description->set($description);

        $this->assertEquals(
            '<meta name="description" content="' . $description .'"/>',
            $this->description->render()
        );
    }
}
