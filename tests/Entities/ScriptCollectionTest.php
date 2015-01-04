<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\ScriptCollection;

class ScriptCollectionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var ScriptCollection */
    private $scriptCollection;

    const SCRIPT_COLLECTION_CLASS = 'Arcanedev\\Head\\Entities\\ScriptCollection';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->scriptCollection = new ScriptCollection;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->scriptCollection);
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
            self::SCRIPT_COLLECTION_CLASS,
            $this->scriptCollection
        );

        $this->assertCount(0, $this->scriptCollection);
    }

    /**
     * @test
     */
    public function testCanAddScript()
    {
        $this->assertCount(0, $this->scriptCollection);

        $this->scriptCollection->add('assets/js/jquery-min.js');
        $this->assertCount(1, $this->scriptCollection);

        $this->scriptCollection->add('assets/js/bootstrap-min.js');
        $this->assertCount(2, $this->scriptCollection);

        $this->scriptCollection->add('assets/js/jquery-min.js');
        $this->assertCount(2, $this->scriptCollection);
    }

    /**
     * @test
     */
    public function testCanAddManyScripts()
    {
        $this->assertCount(0, $this->scriptCollection);

        $this->scriptCollection->addMany([
            'assets/js/jquery-min.js',
            'assets/js/bootstrap-min.js',
            'assets/js/jquery-min.js',    // Duplicated
        ]);

        $this->assertCount(2, $this->scriptCollection);
    }

    /**
     * @test
     */
    public function testCanRender()
    {
        $scripts = [];

        $this->scriptCollection->add('assets/js/jquery-min.js');
        $scripts[] = '<script src="assets/js/jquery-min.js"></script>';
        $this->assertEquals(
            implode(PHP_EOL, $scripts),
            $this->scriptCollection->render()
        );

        $this->scriptCollection->add('assets/js/bootstrap-min.js');
        $scripts[] = '<script src="assets/js/bootstrap-min.js"></script>';
        $this->assertEquals(
            implode(PHP_EOL, $scripts),
            $this->scriptCollection->render()
        );
    }
}
