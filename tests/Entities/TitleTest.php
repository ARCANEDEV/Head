<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Title;

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
    /**
     * @test
     */
    public function testCanInstantiate()
    {
        $this->assertInstanceOf('Arcanedev\\Head\\Entities\\Title', $this->title);
    }

    /**
     * @test
     */
    public function testCanSetTitle()
    {
        $this->title->set('My awesome title');
        $this->assertEquals('My awesome title', $this->title->get());
        $this->assertFalse($this->title->isEmpty());
    }

    /**
     * @test
     */
    public function testCanSetSitename()
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
    public function testCanSetSeparator()
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
    public function testCanRenderTitleOne()
    {
        $this->assertEmpty($this->title->render());
    }

    /**
     * @test
     */
    public function testCanRenderTitleTwo()
    {
        $this->title->set('My awesome title');
        $this->assertEquals('<title>My awesome title</title>', $this->title->render());
    }

    /**
     * @test
     */
    public function testCanRenderTitleThree()
    {
        $this->title->set('My awesome title');
        $this->title->setSiteName('Company Name');
        $this->assertEquals('<title>My awesome title | Company Name</title>', $this->title->render());
    }

    /**
     * @test
     */
    public function testCanRenderTitleFour()
    {
        $this->title->set('My awesome title');
        $this->title->setSiteName('Company Name');
        $this->title->hideSiteName();
        $this->assertEquals('<title>My awesome title</title>', $this->title->render());
    }

    /**
     * @test
     */
    public function testCanRenderTitleFive()
    {
        $this->title->set('My awesome title');
        $this->title->setSiteName('Company Name');
        $this->assertEquals('<title>My awesome title | Company Name</title>', $this->title->render());

        $this->title->siteNameFirst();
        $this->assertEquals('<title>Company Name | My awesome title</title>', $this->title->render());

        $this->title->siteNameLast();
        $this->assertEquals('<title>My awesome title | Company Name</title>', $this->title->render());
    }

    /**
     * @test
     */
    public function testCanRenderTitleSix()
    {
        $this->title->set('My awesome title');
        $this->title->setSiteName('Company Name');
        $this->title->setSeparator('');
        $this->assertEquals('<title>My awesome title Company Name</title>', $this->title->render());
    }
}
