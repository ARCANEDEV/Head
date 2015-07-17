<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\MetaCollection;

/**
 * Class MetaCollectionTest
 * @package Arcanedev\Head\Tests\Entities
 */
class MetaCollectionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var MetaCollection */
    private $metaCollection;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->metaCollection = new MetaCollection;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->metaCollection);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(MetaCollection::class, $this->metaCollection);
        $this->assertCount(0, $this->metaCollection);
    }

    /** @test */
    public function it_can_add_many_metas_from_array()
    {
        $this->metaCollection = MetaCollection::make([
            [
                'name'      => 'author',
                'content'   => 'ARCANEDEV',
            ],[
                'name'      => 'copyright',
                'content'   => 'ARCANEDEV',
            ]
        ]);

        $this->assertCount(2, $this->metaCollection);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\Exception
     * @expectedExceptionMessage The meta [name] attribute not found !
     */
    public function it_must_throw_exception_on_name_not_found()
    {
        MetaCollection::make([
            [
                'name'      => 'author',
                'content'   => 'ARCANEDEV',
            ],[
                'content'   => 'ARCANEDEV',
            ]
        ]);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\Exception
     * @expectedExceptionMessage The meta [content] attribute not found !
     */
    public function it_must_throw_exception_on_content_not_found()
    {
        MetaCollection::make([
            [
                'name'      => 'author',
            ],[
                'name'      => 'copyright',
                'content'   => 'ARCANEDEV',
            ]
        ]);
    }

    /** @test */
    public function it_can_render()
    {
        $metas = [
            [
                'name'      => 'author',
                'content'   => 'ARCANEDEV',
            ],[
                'name'      => 'copyright',
                'content'   => 'ARCANEDEV',
            ]
        ];
        $this->metaCollection = MetaCollection::make($metas);

        $this->assertEquals(
            $this->getRenderedMetas(),
            $this->metaCollection->render()
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    private function getRenderedMetas()
    {
        return implode(PHP_EOL, [
            '<meta name="author" content="ARCANEDEV"/>',
            '<meta name="copyright" content="ARCANEDEV"/>'
        ]);
    }
}
