<?php namespace Arcanedev\Head\Entities\OpenGraph\Objects;

use DateTime;

/**
 * Class Video
 * @package Arcanedev\Head\Entities\OpenGraph\Objects
 */
class Video extends AbstractObject
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Property prefix
     *
     * @var string
     */
    const PREFIX    = 'video';

    /**
     * prefix namespace
     *
     * @var string
     */
    const NS        = 'http://ogp.me/ns/video#';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Array of actor URLs
     *
     * @var array
     */
    protected $actor;

    /**
     * Array of director URLs
     *
     * @var array
     */
    protected $director;

    /**
     * Array of writer URIs
     *
     * @var array
     */
    protected $writer;

    /**
     * Video duration in whole seconds
     *
     * @var int
     */
    protected $duration;

    /**
     * The date the movie was first released. ISO 8601 formatted string
     *
     * @var string
     */
    protected $release_date;

    /**
     * Tag words associated with the movie
     *
     * @var array
     */
    protected $tag;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
        $this->actor    = [];
        $this->director = [];
        $this->writer   = [];
        $this->tag      = [];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get an array of actor URLs
     *
     * @return array actor URLs
     */
    public function getActors()
    {
        return $this->actor;
    }

    /**
     * Add an actor URL with an optional role association
     *
     * @param  string $url  - Author URL of og:type profile
     * @param  string $role - The role the given actor played in this video work.
     *
     * @return self
     */
    public function addActor($url, $role = '')
    {
        if (self::isValidUrl($url) && ! in_array($url, $this->actor)) {
            $this->actor[] = ( ! empty($role) && is_string($role))
                ? [$url, 'role' => $role]
                : $url;
        }

        return $this;
    }

    /**
     * An array of director URLs
     *
     * @return array director URLs
     */
    public function getDirectors()
    {
        return $this->director;
    }

    /**
     * Add a director profile URL
     *
     * @param  string $url - director profile URL
     *
     * @return self
     */
    public function addDirector($url)
    {
        if (self::isValidUrl($url) && ! in_array($url, $this->director)) {
            $this->director[] = $url;
        }

        return $this;
    }

    /**
     * An array of writer URLs
     *
     * @return array - writer URLs
     */
    public function getWriters()
    {
        return $this->writer;
    }

    /**
     * Add a writer profile URL
     *
     * @param  string $url - writer profile URL
     *
     * @return self
     */
    public function addWriter($url)
    {
        if (static::isValidUrl($url) && ! in_array($url, $this->writer)) {
            $this->writer[] = $url;
        }

        return $this;
    }

    /**
     * Duration of the video in whole seconds
     *
     * @return int - duration in whole seconds
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set the video duration in whole seconds
     *
     * @param  int $duration - video duration in whole seconds
     *
     * @return self
     */
    public function setDuration( $duration )
    {
        if (is_int($duration) && $duration > 0) {
            $this->duration = $duration;
        }

        return $this;
    }

    /**
     * The release date as an ISO 8601 formatted string
     *
     * @return string - release date as an ISO 8601 formatted string
     */
    public function getReleaseDate()
    {
        return $this->release_date;
    }

    /**
     * Set the date this video was first released
     *
     * @param  DateTime|string $release_date - date video was first released
     *
     * @return self
     */
    public function setReleaseDate($release_date)
    {
        if ($release_date instanceof DateTime) {
            $this->release_date = static::datetimeToIso8601($release_date);
        }

        // at least YYYY-MM-DD
        if (is_string($release_date) && strlen($release_date) >= 10) {
            $this->release_date = $release_date;
        }

        return $this;
    }

    /**
     * An array of tag words associated with this video
     *
     * @return array - tags
     */
    public function getTags()
    {
        return $this->tag;
    }

    /**
     * Add a tag word or topic related to this video
     *
     * @param  string $tag tag word or topic
     *
     * @return self
     */
    public function addTag($tag)
    {
        if (is_string($tag) && ! in_array($tag, $this->tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }
}
