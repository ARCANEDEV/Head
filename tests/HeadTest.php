<?php namespace Arcanedev\Head\Tests;

use Arcanedev\Head\Head;

use Arcanedev\Head\Entities\Charset     as Charset;
use Arcanedev\Head\Entities\Title       as Title;
use Arcanedev\Head\Entities\Description as Description;
use Arcanedev\Head\Entities\Keywords    as Keywords;

class HeadTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Head */
    protected $head;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function setUp()
    {
        parent::setUp();

        $this->head = new Head;
    }

    protected function tearDown()
    {
        parent::tearDown();

        unset($this->head);
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
        $this->assertInstanceOf('Arcanedev\\Head\\Head', $this->head);
        $this->assertEquals('UTF-8', $this->head->getCharset());
    }

    /**
     * @test
     */
    public function testCanSetAndGetCharset()
    {
        $this->assertEquals('UTF-8', $this->head->getCharset());
        $this->assertEquals(
            '<meta charset="UTF-8">',
            $this->head->getCharsetTag()
        );

        $this->head->setCharset('ISO-8859-1');

        $this->assertEquals('ISO-8859-1', $this->head->getCharset());
        $this->assertEquals(
            '<meta charset="ISO-8859-1">',
            $this->head->getCharsetTag()
        );

        $this->head->setCharset(Charset::make('UTF-8'));

        $this->assertEquals('UTF-8', $this->head->getCharset());
        $this->assertEquals(
            '<meta charset="UTF-8">',
            $this->head->getCharsetTag()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnCharset()
    {
        $this->head->setCharset(true);
    }

    /**
     * @test
     */
    public function canSetAndGetTitle()
    {
        $title = 'Hello Title';
        $this->head->setTitle($title);

        $this->assertEquals($title, $this->head->getTitle());
        $this->assertEquals(
            '<title>Hello Title</title>',
            $this->head->getTitleTag()
        );
    }

    /**
     * @test
     */
    public function canSetAndGetByTitleClass()
    {
        $title = new Title;
        $title->set('Hello Title')
              ->setSiteName('Company Name')
              ->separator('||');

        $this->head->setTitle($title);

        $this->assertEquals('Hello Title', $this->head->getTitle());
        $this->assertEquals(
            '<title>Hello Title || Company Name</title>',
            $this->head->getTitleTag()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnTitle()
    {
        $this->head->setTitle(true);
    }

    /**
     * @test
     */
    public function canSetAndGetDescription()
    {
        $description = 'Hello Description';
        $this->head->setDescription($description);

        $this->assertEquals($description, $this->head->getDescription());
        $this->assertEquals('<meta name="description" content="' . $description . '">', $this->head->getDescriptionTag());
    }

    /**
     * @test
     */
    public function canSetAndGetByDescriptionClass()
    {
        $description = new Description;
        $description->set('Hello Description');
        $this->head->setDescription($description);

        $this->assertEquals('Hello Description', $this->head->getDescription());
        $this->assertEquals('<meta name="description" content="Hello Description">', $this->head->getDescriptionTag());
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnDescription()
    {
        $this->head->setDescription(true);
    }

    /**
     * @test
     */
    public function canSetAndGetKeywords()
    {
        $arrayKeywords  = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];

        $this->head->setKeywords($arrayKeywords);
        $this->assertEquals($arrayKeywords, $this->head->getKeywords());

        $stringKeywords = implode(', ', $arrayKeywords);
        $keywordsTag    = '<meta name="keywords" content="' . $stringKeywords . '">';

        $this->assertEquals($arrayKeywords, $this->head->setKeywords($stringKeywords)->getKeywords());
        $this->assertEquals($keywordsTag, $this->head->getKeywordsTag());
    }

    /**
     * @test
     */
    public function testSetAndGetByKeywordsClass()
    {
        $arrayKeywords  = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];

        $keywords = (new Keywords)->set($arrayKeywords);

        $this->head->setKeywords($keywords);
        $keywordsTag = '<meta name="keywords" content="' . implode(', ', $arrayKeywords) . '">';

        $this->assertEquals($keywordsTag, $this->head->getKeywordsTag());
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnKeywords()
    {
        $this->head->setKeywords(true);
    }

    /**
     * @test
     */
    public function testCanSetAndGetTitleDescriptionKeywords()
    {
        $title       = 'Hello Title';
        $description = 'Hello Description';
        $keywords    = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];
        $this->head->set($title, $description, $keywords);

        $this->assertEquals($title,       $this->head->getTitle());
        $this->assertEquals($description, $this->head->getDescription());
        $this->assertEquals($keywords,    $this->head->getKeywords());
    }

    /**
     * @test
     */
    public function testCanRender()
    {
        $title         = 'Hello world';
        $description   = 'Description of the hello world';
        $arrayKeywords = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];
        $tagsArray     = [
            '<meta charset="UTF-8">',
            '<title>' . $title . '</title>',
            '<meta name="description" content="' . $description . '">',
            '<meta name="keywords" content="' . implode(', ', $arrayKeywords) .'">',
        ];

        $this->head->setTitle($title);
        $this->head->setDescription($description);
        $this->head->setKeywords($arrayKeywords);

        $this->assertEquals(implode(PHP_EOL, $tagsArray), $this->head->render());
    }
}
