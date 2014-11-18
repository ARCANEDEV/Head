<?php namespace Arcanedev\Head\Entities\OpenGraph\Medias;

abstract class VisualMedia extends AbstractMedia
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Height of the media object in pixels
     *
     * @var int
     */
    protected $height;

    /**
     * Width of the media object in pixels
     *
     * @var int
     */
    protected $width;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param int $width
     * @param int $height
     *
     * @return VisualMedia
     */
    public function setDimensions($width, $height)
    {
        $this->setWidth($width);
        $this->setHeight($height);

        return $this;
    }

    /**
     * @return int width in pixels
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set the object width
     *
     * @param int $width - width in pixels
     *
     * @return VisualMedia
     */
    public function setWidth($width)
    {
        if ( $this->isValidDimension($width) ) {
            $this->width = $width;
        }

        return $this;
    }

    /**
     * @return int - height in pixels
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the height of the referenced object in pixels
     *
     * @var int - height of the referenced object in pixels
     *
     * @return VisualMedia
     */
    public function setHeight($height)
    {
        if ( $this->isValidDimension($height) ) {
            $this->height = $height;
        }

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param int $dimension
     *
     * @return bool
     */
    public function isValidDimension($dimension)
    {
        return is_int($dimension) and $dimension > 0;
    }
}
