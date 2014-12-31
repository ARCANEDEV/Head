<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Title;

class TitleTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const TITLE_CLASS = 'Arcanedev\\Head\\Entities\\Title';
    /** @var Title */
    protected $title;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function setUp()
    {
        $this->title = new Title;
    }

    protected function tearDown()
    {
        unset($this->title);
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
        $this->assertInstanceOf(self::TITLE_CLASS, $this->title);

        $this->assertEmpty($this->title->render());
    }

    /**
     * @test
     */
    public function testCanSetAndGetTitle()
    {
        $this->title->set('My awesome title');
        $this->assertEquals('My awesome title', $this->title->get());
        $this->assertFalse($this->title->isEmpty());
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\EmptyTitleException
     */
    public function testMustThrowEmptyTitleException()
    {
        $this->title->set('');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeException()
    {
        $this->title->set(true);
    }

    /**
     * @test
     */
    public function testCanSetAndGetSiteName()
    {
        $this->title->setSiteName('Company Name');
        $this->assertEquals('Company Name', $this->title->siteName());
        $this->assertFalse($this->title->isSiteNameEmpty());
    }

    /**
     * @test
     */
    public function testCanToggleSiteNameVisibility()
    {
        $this->assertTrue($this->title->isSiteNameVisible());
        $this->assertFalse($this->title->isSiteNameHidden());

        $this->title->hideSiteName();
        $this->assertFalse($this->title->isSiteNameVisible());
        $this->assertTrue($this->title->isSiteNameHidden());

        $this->title->showSiteName();
        $this->assertTrue($this->title->isSiteNameVisible());
        $this->assertFalse($this->title->isSiteNameHidden());
    }

    /**
     * @test
     */
    public function testCanSetAndGetSeparator()
    {
        $this->title->separator(' -');
        $this->assertEquals('-', $this->title->separator());
        $this->assertFalse($this->title->isSeparatorEmpty());

        $this->title->separator('| ');
        $this->assertEquals('|', $this->title->separator());
        $this->assertFalse($this->title->isSeparatorEmpty());

        $this->title->setSeparator('');
        $this->assertEquals('', $this->title->separator());
        $this->assertTrue($this->title->isSeparatorEmpty());
    }

    /**
     * @test
     */
    public function testCanRenderTitle()
    {
        $title = 'Hello world';

        $this->assertEquals(
            "<title>$title</title>",
            $this->title->set($title)->render()
        );
    }

    /**
     * @test
     */
    public function testCanRenderTitleWithSiteName()
    {
        $title    = 'My awesome title';
        $siteName = 'Site Name';
        $this->title->set($title)->setSiteName($siteName);

        $this->assertEquals(
            "<title>$title | $siteName</title>",
            $this->title->render()
        );
    }

    /**
     * @test
     */
    public function testCanRenderTitleWithoutSiteName()
    {
        $title    = 'My awesome title';
        $siteName = 'Site Name';
        $this->title->set($title)->setSiteName($siteName);

        $this->title->hideSiteName();

        $this->assertEquals(
            '<title>My awesome title</title>',
            $this->title->render()
        );
    }

    /**
     * @test
     */
    public function testCanRenderTitleWithOrder()
    {

        $title    = 'My awesome title';
        $siteName = 'Site Name';
        $this->title->set($title)->setSiteName($siteName);

        $this->assertEquals(
            "<title>$title | $siteName</title>",
            $this->title->render()
        );

        $this->title->siteNameFirst();
        $this->assertEquals(
            "<title>$siteName | $title</title>",
            $this->title->render()
        );

        $this->title->siteNameLast();
        $this->assertEquals(
            "<title>$title | $siteName</title>",
            $this->title->render()
        );
    }

    /**
     * @test
     */
    public function testCanRenderTitleSix()
    {
        $this->title->set('My awesome title')->setSiteName('Company Name');
        $this->title->setSeparator('');

        $this->assertEquals('<title>My awesome title Company Name</title>', $this->title->render());
    }
}
