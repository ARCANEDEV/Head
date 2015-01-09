<?php namespace Arcanedev\Head\Tests\Entities;


use Arcanedev\Head\Entities\Meta;

class MetaTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Meta */
    private $meta;

    const META_CLASS = 'Arcanedev\\Head\\Entities\\Meta';

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
    /**
     * @test
     */
    public function testCanBeInstantiated()
    {
        $this->assertInstanceOf(self::META_CLASS, $this->meta);
        $this->assertTrue($this->meta->isEmpty());

        $this->meta = Meta::make('author', 'ARCANEDEV');
        $this->assertInstanceOf(self::META_CLASS, $this->meta);
        $this->assertFalse($this->meta->isEmpty());
    }

    /**
     * @test
     */
    public function testCanSetAndGet()
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
    public function testMustThrowExceptionOnEmptyName()
    {
        Meta::make('', 'content');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnName()
    {
        Meta::make(true, 'content');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\Exception
     */
    public function testMustThrowExceptionOnEmptyContent()
    {
        Meta::make('name', '');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnContent()
    {
        Meta::make('name', true);
    }

    /**
     * @test
     */
    public function testCanRender()
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

    /**
     * @test
     */
    public function testCanGetResponsiveTag()
    {
        $this->assertEquals(
            '<meta name="viewport" content="width=device-width, initial-scale=1.0">',
            $this->meta->responsive()
        );
    }

    /**
     * @test
     */
    public function testCanGetIeEdgeTag()
    {
        $this->assertEquals(
            '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">',
            $this->meta->ieEdge()
        );
    }
}
