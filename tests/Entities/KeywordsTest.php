<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Keywords;

class KeywordsTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Keywords */
    private $keywords;

    const KEYWORDS_CLASS = 'Arcanedev\\Head\\Entities\\Keywords';

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
    /**
     * @test
     */
    public function testCanInstantiate()
    {
        $this->assertInstanceOf(self::KEYWORDS_CLASS, $this->keywords);

        $this->assertTrue($this->keywords->isEmpty());
        $this->assertEquals([], $this->keywords->get());
    }

    /**
     * @test
     */
    public function testCanSetAndGetKeywordsFromArray()
    {
        $arrayKeywords = $this->getKeywordsArray();
        $this->keywords->set($arrayKeywords);

        $this->assertEquals(5, $this->keywords->count());
        $this->assertEquals($arrayKeywords, $this->keywords->get());
    }

    /**
     * @test
     */
    public function testCanSetAndGetKeywordsFromString()
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
    public function testMustThrowInvalidTypeException()
    {
        $this->keywords->set(true);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnArrayKeywords()
    {
        $this->keywords->set([
            'keyword 1', 'keyword 2', 123, false
        ]);
    }

    /**
     * @test
     */
    public function testCanRender()
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
