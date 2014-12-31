<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\MetaCollection;

class MetaCollectionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const META_COLLECTION_CLASS = 'Arcanedev\\Head\\Entities\\MetaCollection';
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
    /**
     * @test
     */
    public function testCanBeInstantiated()
    {
        $this->assertInstanceOf(
            self::META_COLLECTION_CLASS,
            $this->metaCollection
        );

        $this->assertCount(0, $this->metaCollection);
    }

    /**
     * @test
     */
    public function testCanAddManyMetasFromArray()
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

        $this->assertCount(2, $this->metaCollection);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\Exception
     * @expectedExceptionMessage The meta [name] attribute not found !
     */
    public function testMustThrowExceptionOnNameNotFound()
    {
        $metas = [
            [
                'name'      => 'author',
                'content'   => 'ARCANEDEV',
            ],[
                'content'   => 'ARCANEDEV',
            ]
        ];

        MetaCollection::make($metas);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\Exception
     * @expectedExceptionMessage The meta [content] attribute not found !
     */
    public function testMustThrowExceptionOnContentNotFound()
    {
        $metas = [
            [
                'name'      => 'author',
            ],[
                'name'      => 'copyright',
                'content'   => 'ARCANEDEV',
            ]
        ];

        MetaCollection::make($metas);
    }

    public function testCanRender()
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
            '<meta name="author" content="ARCANEDEV">',
            '<meta name="copyright" content="ARCANEDEV">'
        ]);
    }
}
