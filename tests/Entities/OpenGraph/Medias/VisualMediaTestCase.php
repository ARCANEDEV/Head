<?php namespace Arcanedev\Head\Tests\Entities\OpenGraph\Medias;

use Arcanedev\Head\Entities\OpenGraph\Medias\VisualMedia;

abstract class VisualMediaTestCase extends AbstractMediaTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var VisualMedia */
    protected $media;

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @test
     */
    public function assertVisualMediaInstance()
    {
        if ( ! is_null($this->media) ) {
            $this->assertInstanceOf('Arcanedev\\Head\\Entities\\OpenGraph\\Medias\\VisualMedia', $this->media);
        }
    }

    /**
     * @test
     */
    public function assertCanSetAndGetWidthAndHeight()
    {
        if ( ! is_null($this->media) ) {
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
