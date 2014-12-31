<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Description;

class DescriptionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Description */
    protected $description;

    const DESCRIPTION_CLASS = 'Arcanedev\\Head\\Entities\\Description';

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
        $this->assertInstanceOf(self::DESCRIPTION_CLASS, $this->description);
        $this->assertTrue($this->description->isEmpty());
    }

    /**
     * @test
     */
    public function testCanSetAndGetDescription()
    {
        $this->assertEquals('', $this->description->get());

        $description = 'Hello world description';

        $this->assertEquals(
            $description,
            $this->description->set($description)->get()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeException()
    {
        $this->description->set(true);
    }

    /**
     * @test
     */
    public function testCanRender()
    {
        $this->assertEquals('', $this->description->render());

        $description = 'Hello world description';
        $this->description->set($description);

        $this->assertEquals(
            '<meta name="description" content="' . $description .'">',
            $this->description->render()
        );
    }
}
