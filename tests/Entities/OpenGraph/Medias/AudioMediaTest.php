<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Entities\OpenGraph\Medias\AudioMedia;

class AudioMediaTest extends AbstractMediaTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var AudioMedia */
    protected $media;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function setUp()
    {
        $this->media = new AudioMedia;
    }

    protected function tearDown()
    {
        unset($this->media);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function testCanInstantiate()
    {
        $this->assertInstanceOf('Arcanedev\\Head\\Entities\\OpenGraph\\Medias\\AudioMedia', $this->media);
        $this->assertAbstractMediaInstance();
    }

    /**
     * @test
     */
    public function testCanSetAndGetURL($url = '')
    {
        parent::testCanSetAndGetURL('http://www.company.com/audio.mp3');
    }

    /**
     * @test
     */
    public function testCanSetAndGetSecureURL($secureURL = '')
    {
        parent::testCanSetAndGetSecureURL('https://www.company.com/audio.mp3');
    }

    /**
     * @test
     */
    public function testCanSetAndGetType($type = '')
    {
        parent::testCanSetAndGetType('audio/mpeg');
    }
}
