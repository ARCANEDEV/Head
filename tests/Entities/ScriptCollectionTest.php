<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\ScriptCollection;

/**
 * Class ScriptCollectionTest
 * @package Arcanedev\Head\Tests\Entities
 */
class ScriptCollectionTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var ScriptCollection */
    private $scriptCollection;

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
    /** @test */
    public function test_can_be_instantiated()
    {
        $this->assertInstanceOf(ScriptCollection::class, $this->scriptCollection);
        $this->assertCount(0, $this->scriptCollection);
    }

    /** @test */
    public function test_can_add_script()
    {
        $this->scriptCollection->add('assets/js/jquery-min.js');
        $this->assertCount(1, $this->scriptCollection);

        $this->scriptCollection->add('assets/js/bootstrap-min.js');
        $this->assertCount(2, $this->scriptCollection);

        $this->scriptCollection->add('assets/js/jquery-min.js');
        $this->assertCount(2, $this->scriptCollection);
    }

    /** @test */
    public function test_can_add_many_scripts()
    {
        $this->scriptCollection->addMany([
            'assets/js/jquery-min.js',
            'assets/js/bootstrap-min.js',
            'assets/js/jquery-min.js',    // Duplicated
        ]);

        $this->assertCount(2, $this->scriptCollection);
    }

    /** @test */
    public function test_can_render()
    {
        $scripts = [];

        $script = 'assets/js/jquery-min.js';
        $this->scriptCollection->add($script);
        $scripts[] = $this->getTag($script);

        $this->assertCount(1, $this->scriptCollection);
        $this->assertEquals(
            implode(PHP_EOL, $scripts),
            $this->scriptCollection->render()
        );

        $script = 'assets/js/bootstrap-min.js';
        $this->scriptCollection->add($script);
        $scripts[] = $this->getTag($script);

        $this->assertCount(2, $this->scriptCollection);
        $this->assertEquals(
            implode(PHP_EOL, $scripts),
            $this->scriptCollection->render()
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Script Tag
     *
     * @param string $src
     *
     * @return string
     */
    private function getTag($src)
    {
        return '<script src="' . $src . '"></script>';
    }
}
