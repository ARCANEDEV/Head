<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Description;

class DescriptionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const DESCRIPTION_CLASS = 'Arcanedev\\Head\\Entities\\Description';

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
    /**
     * @test
     */
    public function test_can_be_instantiated()
    {
        $this->assertInstanceOf(self::DESCRIPTION_CLASS, $this->description);
        $this->assertTrue($this->description->isEmpty());
    }

    /**
     * @test
     */
    public function test_can_set_and_get_description()
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
    public function test_must_throw_invalid_type_exception()
    {
        $this->description->set(true);
    }

    /**
     * @test
     */
    public function test_can_render()
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
