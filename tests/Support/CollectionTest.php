<?php namespace Arcanedev\Head\Tests\Support;

use Arcanedev\Head\Support\Collection;
use Arcanedev\Head\Tests\TestCase;

class CollectionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const COLLECTION_CLASS = 'Arcanedev\\Head\\Support\\Collection';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Collection */
    private $collection;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->collection = new Collection;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->collection);
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
        $this->assertInstanceOf(self::COLLECTION_CLASS, $this->collection);
        $this->assertCount(0, $this->collection);
    }

    /**
     * @test
     */
    public function test_can_add()
    {
        $this->collection->put('foo', 'bar');
        $this->assertCount(1, $this->collection);

        $this->collection->put('bar', 'foo');
        $this->assertCount(2, $this->collection);
    }

    /**
     * @test
     */
    public function test_can_add_like_array()
    {
        $this->collection['foo'] = 'bar';
        $this->assertCount(1, $this->collection);

        $this->collection['bar'] = 'foo';
        $this->assertCount(2, $this->collection);

        $this->collection[] = 'value';
        $this->assertCount(3, $this->collection);
    }

    /**
     * @test
     */
    public function test_can_get_all()
    {
        $this->collection->put('foo', 'bar');
        $this->collection->put('bar', 'foo');

        $items = $this->collection->all();

        $this->assertEquals(2, count($items));
        $this->assertArrayHasKey('foo', $items);
        $this->assertArrayHasKey('bar', $items);

        $items = $this->collection->toArray();

        $this->assertEquals(2, count($items));
        $this->assertArrayHasKey('foo', $items);
        $this->assertArrayHasKey('bar', $items);
    }

    /**
     * @test
     */
    public function test_can_get_one()
    {
        $this->collection->put('foo', 'bar');
        $this->collection->put('bar', 'foo');

        $this->assertEquals('bar', $this->collection->get('foo'));
        $this->assertEquals('foo', $this->collection->get('bar'));

        $default = 'hello';
        $this->assertEquals($default, $this->collection->get('baz', $default));
    }

    /**
     * @test
     */
    public function test_can_unset()
    {
        $this->collection->put('foo', 'bar');
        $this->collection->put('bar', 'foo');

        $this->assertCount(2, $this->collection);

        $this->collection->forget('foo');

        $this->assertCount(1, $this->collection);
        $this->assertNull($this->collection->get('foo'));
    }

    /**
     * @test
     */
    public function test_can_each_loop()
    {
        $this->collection->put('foo', 'bar');
        $this->collection->put('bar', 'foo');

        $this->collection->each(function($item) {
            $this->assertTrue(in_array($item, ['bar', 'foo']));
        });
    }

    /**
     * @test
     */
    public function test_can_instantiate_with_collection()
    {
        $collection = new Collection([
            'foo'   => 'bar',
            'bar'   => 'foo',
        ]);

        $this->assertCount(2, $collection);

        $this->collection = new Collection($collection);

        $this->assertCount(2, $this->collection);
    }
}
