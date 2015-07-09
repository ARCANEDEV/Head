<?php namespace Arcanedev\Head\Entities\OpenGraph\Medias;

/**
 * Class VisualMedia
 * @package Arcanedev\Head\Entities\OpenGraph\Medias
 */
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
     * Set dimensions
     *
     * @param  int $width
     * @param  int $height
     *
     * @return self
     */
    public function setDimensions($width, $height)
    {
        $this->setWidth($width);
        $this->setHeight($height);

        return $this;
    }

    /**
     * Get width in pixels
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set the object width in pixels
     *
     * @param  int $width
     *
     * @return self
     */
    public function setWidth($width)
    {
        if ($this->isValidDimension($width)) {
            $this->width = $width;
        }

        return $this;
    }

    /**
     * Get height in pixels
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the height of the referenced object in pixels
     *
     * @param  int
     *
     * @return self
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
     * Check is valid dimension
     *
     * @param  int $dimension
     *
     * @return bool
     */
    public function isValidDimension($dimension)
    {
        return is_int($dimension) && $dimension > 0;
    }
}
