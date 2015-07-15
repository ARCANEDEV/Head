<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Entities\Analytics;

/**
 * Class AnalyticsTest
 * @package Arcanedev\Head\Tests\Entities
 */
class AnalyticsTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Analytics */
    private $analytics;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->analytics = new Analytics;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->analytics);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Analytics::class, $this->analytics);
        $this->assertTrue($this->analytics->isEnabled());
        $this->assertEmpty($this->analytics->render());
    }

    /** @test */
    public function it_can_init_with_id()
    {
        $id = 'UA-12345678-9';
        $this->analytics->setId($id);

        $this->assertEquals($this->getScript($id), $this->analytics->render());
    }

    /** @test */
    public function it_load_config()
    {
        $id     = 'UA-12345678-9';
        $config = [
            'active'    => true,
            'id'        => $id,
        ];

        $this->analytics->setConfig($config);

        $this->assertEquals($this->getScript($id), $this->analytics->render());
    }

    /** @test */
    public function it_can_enable_and_disable()
    {
        $this->analytics->disable();

        $this->assertFalse($this->analytics->isEnabled());

        $this->analytics->enable();

        $this->assertTrue($this->analytics->isEnabled());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    private function getScript($id)
    {
        return <<< HEAD
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '$id', 'auto');
  ga('send', 'pageview');
</script>
HEAD;
    }
}
