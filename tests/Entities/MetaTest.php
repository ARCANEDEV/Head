<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Meta;

/**
 * Class MetaTest
 * @package Arcanedev\Head\Tests\Entities
 */
class MetaTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Meta */
    private $meta;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->meta = new Meta;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->meta);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function test_can_be_instantiated()
    {
        $this->assertInstanceOf(Meta::class, $this->meta);
        $this->assertTrue($this->meta->isEmpty());
    }

    /** @test */
    public function it_can_make()
    {
        $this->meta = Meta::make('author', 'ARCANEDEV');
        $this->assertInstanceOf(Meta::class, $this->meta);
        $this->assertFalse($this->meta->isEmpty());
    }

    /** @test */
    public function test_can_set_and_get()
    {
        $meta = [
            'name'       => 'author',
            'content'    => 'ARCANEDEV',
            'attributes' => [],
        ];
        $this->meta->set($meta['name'], $meta['content']);

        $this->assertFalse($this->meta->isEmpty());
        $this->assertEquals($meta, $this->meta->get());
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\Exception
     */
    public function test_must_throw_exception_on_empty_name()
    {
        Meta::make('', 'content');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function test_must_throw_invalid_type_exception_on_name()
    {
        Meta::make(true, 'content');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\Exception
     */
    public function test_must_throw_exception_on_empty_content()
    {
        Meta::make('name', '');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function test_must_throw_invalid_type_exception_on_content()
    {
        Meta::make('name', true);
    }

    /** @test */
    public function test_can_render()
    {
        $meta = [
            'name'      => 'author',
            'content'   => 'ARCANEDEV',
            'attributes'=> [],
        ];
        $this->meta->set($meta['name'], $meta['content']);

        $this->assertEquals(
            '<meta name="' . $meta['name'] . '" content="' . $meta['content'] . '"/>',
            $this->meta->render()
        );
    }

    /** @test */
    public function test_can_get_responsive_tag()
    {
        $this->assertEquals(
            '<meta name="viewport" content="width=device-width, initial-scale=1.0">',
            $this->meta->responsive()
        );
    }

    /** @test */
    public function test_can_get_ie_edge_tag()
    {
        $this->assertEquals(
            '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">',
            $this->meta->ieEdge()
        );
    }
}
