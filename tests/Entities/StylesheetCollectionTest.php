<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\StylesheetCollection;

class StylesheetCollectionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const STYLESHEET_COLLECTION_CLASS = 'Arcanedev\\Head\\Entities\\StylesheetCollection';
    /** @var StylesheetCollection */
    private $styleCollection;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->styleCollection = new StylesheetCollection;

        $this->assertCount(0, $this->styleCollection);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->styleCollection);
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
            self::STYLESHEET_COLLECTION_CLASS,
            $this->styleCollection
        );
    }

    /**
     * @test
     */
    public function testCanAddStyle()
    {
        $this->styleCollection->add('assets/css/style.css');
        $this->assertCount(1, $this->styleCollection);

        $this->styleCollection->add('assets/css/bootstrap-min.css');
        $this->assertCount(2, $this->styleCollection);

        $this->styleCollection->add('assets/css/style.css');
        $this->assertCount(2, $this->styleCollection);
    }

    /**
     * @test
     */
    public function testCanAddManyStyles()
    {
        $this->styleCollection->addMany([
            'assets/css/style.css',
            'assets/css/bootstrap-min.css',
            'assets/css/style.css',
        ]);
        $this->assertCount(2, $this->styleCollection);
    }

    /**
     * @test
     */
    public function testCanRender()
    {
        $styles = [];

        $this->styleCollection->add('assets/css/style.css');
        $styles[] = '<link rel="stylesheet" src="assets/css/style.css">';
        $this->assertEquals(
            implode(PHP_EOL, $styles),
            $this->styleCollection->render()
        );

        $this->styleCollection->add('assets/css/bootstrap.min.css');
        $styles[] = '<link rel="stylesheet" src="assets/css/bootstrap.min.css">';
        $this->assertEquals(
            implode(PHP_EOL, $styles),
            $this->styleCollection->render()
        );
    }
}
