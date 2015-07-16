<?php namespace Arcanedev\Head\Entities\OpenGraph\Objects;

/**
 * Class VideoEpisode
 * @package Arcanedev\Head\Entities\OpenGraph\Objects
 */
class VideoEpisode extends Video
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
     * @param  string $url URL of a video.tv_show
     *
     * @return self
     */
    public function setSeries($url)
    {
        if (self::isValidUrl($url)) {
            $this->series = $url;
        }

        return $this;
    }
}
