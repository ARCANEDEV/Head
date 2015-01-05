<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\StylesheetCollection;

class StylesheetCollectionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var StylesheetCollection */
    private $styleCollection;

    const STYLESHEET_COLLECTION_CLASS = 'Arcanedev\\Head\\Entities\\StylesheetCollection';

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
            'assets/css/style.css', // Duplicated
        ]);

        $this->assertCount(2, $this->styleCollection);
    }

    /**
     * @test
     */
    public function testCanRender()
    {
        $styles = [];

        $style = 'assets/css/style.css';
        $this->styleCollection->add($style);
        $styles[] = $this->getTag($style);

        $this->assertCount(1, $this->styleCollection);
        $this->assertEquals(
            implode(PHP_EOL, $styles),
            $this->styleCollection->render()
        );

        $style = 'assets/css/bootstrap.min.css';
        $this->styleCollection->add($style);
        $styles[] = $this->getTag($style);

        $this->assertCount(2, $this->styleCollection);
        $this->assertEquals(
            implode(PHP_EOL, $styles),
            $this->styleCollection->render()
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Style Tag
     *
     * @param string $src
     *
     * @return string
     */
    private function getTag($src)
    {
        return '<link rel="stylesheet" src="' . $src . '">';
    }
}
