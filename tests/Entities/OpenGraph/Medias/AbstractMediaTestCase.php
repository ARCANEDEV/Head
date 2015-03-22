<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Entities\OpenGraph\Medias\AbstractMedia;
use Arcanedev\Head\Tests\Entities\TestCase;

abstract class AbstractMediaTestCase extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const OG_ABSTRACT_MEDIA_CLASS = 'Arcanedev\\Head\\Entities\\OpenGraph\\Medias\\AbstractMedia';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var AbstractMedia */
    protected $media;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function assertAbstractMediaInstance()
    {
        if ( $this->isMediaNotNull() ) {
            $this->assertInstanceOf(self::OG_ABSTRACT_MEDIA_CLASS, $this->media);
        }
    }

    protected function assertCanSetAndGetURL($url)
    {
        if ( $this->isMediaNotNull() ) {
            $this->assertEquals($url, $this->media->setURL($url)->getURL());
        }
    }

    protected function assertCanSetAndGetSecureURL($secureURL)
    {
        if ( $this->isMediaNotNull() ) {
            $this->assertEquals($secureURL, $this->media->setSecureURL($secureURL)->getSecureURL());
        }
    }

    protected function assertCanSetAndGetType($type = '')
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
