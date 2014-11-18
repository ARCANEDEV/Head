<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Tests\Entities\TestCase;

use Arcanedev\Head\Entities\OpenGraph\Medias\AbstractMedia;

abstract class AbstractMediaTestCase extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var AbstractMedia */
    protected $media;

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @test
     */
    public function assertAbstractMediaInstance()
    {
        if ( ! is_null($this->media) ) {
            $this->assertInstanceOf('Arcanedev\\Head\\Entities\\OpenGraph\\Medias\\AbstractMedia', $this->media);
        }
    }

    public function testCanSetAndGetURL($url)
    {
        $this->assertEquals($url, $this->media->setURL($url)->getURL());
    }

    public function testCanSetAndGetSecureURL($secureURL = '')
    {
        $this->assertEquals($secureURL, $this->media->setSecureURL($secureURL)->getSecureURL());
    }

    public function testCanSetAndGetType($type = '')
    {
        $this->assertEquals($type, $this->media->setType($type)->getType());
    }
}
