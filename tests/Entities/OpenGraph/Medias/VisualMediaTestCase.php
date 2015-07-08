<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Entities\OpenGraph\Medias\VisualMedia;

/**
 * Class VisualMediaTestCase
 * @package Arcanedev\Head\Tests\Entities\OpenGraph\Medias
 */
abstract class VisualMediaTestCase extends AbstractMediaTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var VisualMedia */
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
    protected function assertVisualMediaInstance()
    {
        if ( $this->isMediaNotNull() ) {
            $this->assertInstanceOf(VisualMedia::class, $this->media);
        }
    }

    protected function assertCanSetAndGetWidthAndHeight()
    {
        if ( $this->isMediaNotNull() ) {
            $width  = 300;
            $height = 300;

            $this->media->setWidth($width)->setHeight($height);
            $this->assertEquals($width, $this->media->getWidth());
            $this->assertEquals($height, $this->media->getHeight());

            $width  = 150;
            $height = 150;

            $this->media->setDimensions($width, $height);

            $this->assertEquals($width, $this->media->getWidth());
            $this->assertEquals($height, $this->media->getHeight());
        }
    }
}
