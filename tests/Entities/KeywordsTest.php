<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Keywords;

/**
 * Class KeywordsTest
 * @package Arcanedev\Head\Tests\Entities
 */
class KeywordsTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Keywords */
    private $keywords;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function setUp()
    {
        $this->keywords = new Keywords;
    }

    protected function tearDown()
    {
        unset($this->keywords);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Keywords::class, $this->keywords);
        $this->assertTrue($this->keywords->isEmpty());
        $this->assertEmpty($this->keywords->render());
        $this->assertEquals([], $this->keywords->get());
    }

    /** @test */
    public function it_can_set_and_get_keywords_from_array()
    {
        $arrayKeywords = $this->getKeywordsArray();
        $this->keywords->set($arrayKeywords);

        $this->assertEquals(5, $this->keywords->count());
        $this->assertEquals($arrayKeywords, $this->keywords->get());
    }

    /** @test */
    public function it_can_set_and_get_keywords_from_string()
    {
        $stringKeywords = $this->getKeywordsString();
        $this->keywords->set($stringKeywords);

        $this->assertEquals(5, $this->keywords->count());
        $this->assertEquals($this->getKeywordsArray(), $this->keywords->get());
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function it_must_throw_invalid_type_exception()
    {
        $this->keywords->set(true);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function it_must_throw_invalid_type_exception_on_array_keywords()
    {
        $this->keywords->set([
            'keyword 1', 'keyword 2', 123, false
        ]);
    }

    /** @test */
    public function it_can_render()
    {
        $this->assertEquals('', $this->keywords->render());

        $this->keywords->set($this->getKeywordsArray());

        $this->assertEquals(
            $this->getKeywordsTag(),
            $this->keywords->render()
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    private function getKeywordsArray()
    {
        return ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];
    }

    private function getKeywordsString()
    {
        return implode(', ', $this->getKeywordsArray());
    }

    private function getKeywordsTag()
    {
        return '<meta name="keywords" content="' . $this->getKeywordsString() . '"/>';
    }
}
