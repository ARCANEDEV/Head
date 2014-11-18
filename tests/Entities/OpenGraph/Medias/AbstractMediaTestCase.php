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
        if ( $this->isMediaNotNull() ) {
            $this->assertInstanceOf('Arcanedev\\Head\\Entities\\OpenGraph\\Medias\\AbstractMedia', $this->media);
        }
    }

    public function testCanSetAndGetURL($url)
    {
        if ( $this->isMediaNotNull() ) {
            $this->assertEquals($url, $this->media->setURL($url)->getURL());
        }
    }

    public function testCanSetAndGetSecureURL($secureURL = '')
    {
        if ( $this->isMediaNotNull() ) {
            $this->assertEquals($secureURL, $this->media->setSecureURL($secureURL)->getSecureURL());
        }
    }

    public function testCanSetAndGetType($type = '')
    {
        if ( $this->isMediaNotNull() ) {
            $this->assertEquals($type, $this->media->setType($type)->getType());
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function isMediaNull()
    {
        return is_null($this->media);
    }

    /**
     * @return bool
     */
    protected function isMediaNotNull()
    {
        return ! $this->isMediaNull();
    }
}
