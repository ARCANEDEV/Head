<?php namespace Arcanedev\Head\Entities\OpenGraph\Objects;

/**
 * Class VideoEpisodeObject
 * @package Arcanedev\Head\Entities\OpenGraph\Objects
 */
class VideoEpisodeObject extends VideoObject
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * URL of a video.tv_show which this episode belongs to
     *
     * @var string
     */
    protected $series;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * URL of a video.tv_show which this episode belongs to
     *
     * @return string
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Set the URL of a video.tv_show which this episode belongs to
     *
     * @param string $url URL of a video.tv_show
     *
     * @return VideoEpisodeObject
     */
    public function setSeries( $url )
    {
        if (self::isValidUrl($url)) {
            $this->series = $url;
        }

        return $this;
    }
}
