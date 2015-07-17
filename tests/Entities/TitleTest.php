<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Title;

/**
 * Class TitleTest
 * @package Arcanedev\Head\Tests\Entities
 */
class TitleTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
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
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Title::class, $this->title);
        $this->assertEmpty($this->title->render());
    }

    /** @test */
    public function it_can_set_and_get_title()
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
    public function it_must_throw_empty_title_exception()
    {
        $this->title->set('');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function it_must_throw_invalid_type_exception()
    {
        $this->title->set(true);
    }

    /** @test */
    public function it_can_set_and_get_site_name()
    {
        $siteName = 'Company Name';
        $this->title->setSiteName($siteName);

        $this->assertFalse($this->title->isSiteNameEmpty());
        $this->assertEquals($siteName, $this->title->siteName());
    }

    /** @test */
    public function it_can_toggle_site_name_visibility()
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

    /** @test */
    public function it_can_set_and_get_separator()
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

    /** @test */
    public function it_can_render_title()
    {
        $title = 'Hello world';

        $this->assertEquals(
            "<title>$title</title>",
            $this->title->set($title)->render()
        );
    }

    /** @test */
    public function it_can_render_title_with_siteName()
    {
        $title    = 'My awesome title';
        $siteName = 'Site Name';
        $this->title->set($title)->setSiteName($siteName);

        $this->assertEquals(
            "<title>$title | $siteName</title>",
            $this->title->render()
        );
    }

    /** @test */
    public function it_can_render_title_without_site_name()
    {
        $title    = 'My awesome title';
        $siteName = 'Site Name';
        $this->title->set($title)->setSiteName($siteName);

        $this->title->hideSiteName();

        $this->assertEquals(
            "<title>$title</title>",
            $this->title->render()
        );
    }

    /** @test */
    public function it_can_render_title_with_order()
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

    /** @test */
    public function it_can_render_title_six()
    {
        $title     = 'My awesome title';
        $siteName  = 'Company Name';
        $separator = '';
        $this->title->set($title)
            ->setSiteName($siteName)
            ->setSeparator($separator);

        $this->assertEquals(
            "<title>$title $siteName</title>",
            $this->title->render()
        );
    }
}
