<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\StylesheetCollection;

/**
 * Class StylesheetCollectionTest
 * @package Arcanedev\Head\Tests\Entities
 */
class StylesheetCollectionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
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
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(
            StylesheetCollection::class,
            $this->styleCollection
        );
    }

    /** @test */
    public function it_can_add_style()
    {
        $this->styleCollection->add('assets/css/style.css');
        $this->assertCount(1, $this->styleCollection);

        $this->styleCollection->add('assets/css/bootstrap-min.css');
        $this->assertCount(2, $this->styleCollection);

        $this->styleCollection->add('assets/css/style.css');
        $this->assertCount(2, $this->styleCollection);
    }

    /** @test */
    public function it_can_add_many_styles()
    {
        $this->styleCollection->addMany([
            'assets/css/style.css',
            'assets/css/bootstrap.min.css',
            'assets/css/style.css', // Duplicated
        ]);

        $this->assertCount(2, $this->styleCollection);
    }

    public function it_can_ignore_duplicated_styles()
    {
        $this->styleCollection->add('assets/css/bootstrap.min.css');
        $this->styleCollection->add('assets/css/style.css');

        $this->styleCollection->addMany([
            'assets/css/bootstrap.min.css',
            'assets/css/style.css',
        ]);

        $this->assertCount(2, $this->styleCollection);
    }

    /** @test */
    public function it_can_render()
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
        return '<link rel="stylesheet" href="' . $src . '">';
    }
}
