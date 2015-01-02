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
    private $stylesheetCollection;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->stylesheetCollection = new StylesheetCollection;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->stylesheetCollection);
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
            $this->stylesheetCollection
        );

        $this->assertCount(0, $this->stylesheetCollection);
    }

    /**
     * @test
     */
    public function testCanAddScript()
    {
        $this->assertCount(0, $this->stylesheetCollection);

        $this->stylesheetCollection->add('assets/css/style.css');

        $this->assertCount(1, $this->stylesheetCollection);

        $this->stylesheetCollection->add('assets/css/bootstrap-min.css');

        $this->assertCount(2, $this->stylesheetCollection);

        $this->stylesheetCollection->add('assets/css/style.css');

        $this->assertCount(2, $this->stylesheetCollection);
    }
}
