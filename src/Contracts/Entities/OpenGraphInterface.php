<?php namespace Arcanedev\Head\Contracts\Entities;

use Arcanedev\Head\Entities\OpenGraph\Medias\AudioMedia;
use Arcanedev\Head\Entities\OpenGraph\Medias\ImageMedia;
use Arcanedev\Head\Entities\OpenGraph\Medias\VideoMedia;

/**
 * Interface OpenGraphInterface
 * @package Arcanedev\Head\Contracts\Entities
 */
interface OpenGraphInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the Type slug
     *
     * @return string
     */
    public function getType();

    /**
     * Set the Type slug
     *
     * @param string $type
     *
     * @return OpenGraphInterface
     */
    public function setType($type);

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set Title
     *
     * @param string $title
     *
     * @return OpenGraphInterface
     */
    public function setTitle($title);

    /**
     * Get Site name
     *
     * @return string
     */
    public function getSiteName();

    /**
     * Set Site name
     *
     * @param string $siteName
     *
     * @return OpenGraphInterface
     */
    public function setSiteName($siteName);

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set Description
     *
     * @param string $description
     *
     * @return OpenGraphInterface
     */
    public function setDescription($description);

    /**
     * Get the Canonical URL
     *
     * @return string
     */
    public function getURL();

    /**
     * Set the Canonical URL
     *
     * @param string $url
     *
     * @return OpenGraphInterface
     */
    public function setURL($url);

    /**
     * Get the determiner
     *
     * @return string
     */
    public function getDeterminer();

    /**
     * Set the determiner
     *
     * @param string $determiner
     *
     * @return OpenGraphInterface
     */
    public function setDeterminer($determiner);

    /**
     * Get the locale (language_TERRITORY)
     *
     * @return string
     */
    public function getLocale();

    /**
     * Set locale in the format (language_TERRITORY)
     *
     * @var string $locale
     *
     * @return OpenGraphInterface
     */
    public function setLocale($locale);

    /**
     * Get ImageMedia array
     *
     * @return array
     */
    public function getImages();

    /**
     * Add an image.
     * The first image added is given priority by the Open Graph Protocol spec.
     * Implementors may choose a different image based on size requirements or preferences.
     *
     * @param ImageMedia $image
     *
     * @return OpenGraphInterface
     */
    public function addImage(ImageMedia $image);

    /**
     * Get VideoMedia array
     *
     * @return array
     */
    public function getVideos();

    /**
     * Add a video reference
     * The first video is given priority by the Open Graph protocol spec.
     * Implementors may choose a different video based on size requirements or preferences.
     *
     * @param VideoMedia $video
     *
     * @return OpenGraphInterface
     */
    public function addVideo(VideoMedia $video);

    /**
     * Get AudioMedia array
     *
     * @return array
     */
    public function getAudios();

    /**
     * Add an audio reference
     * The first audio is given priority by the Open Graph protocol spec.
     *
     * @param AudioMedia $audio
     *
     * @return OpenGraphInterface|string
     */
    public function addAudio(AudioMedia $audio);

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Enable OpenGraph
     *
     * @return OpenGraphInterface
     */
    public function enable();

    /**
     * Disable OpenGraph
     *
     * @return OpenGraphInterface
     */
    public function disable();

    /**
     * Render OpenGraph
     *
     * @return string
     */
    public function render();

    /**
     * Get Images Count
     *
     * @return int
     */
    public function imagesCount();

    /**
     * Get Videos Count
     *
     * @return int
     */
    public function videosCount();

    /**
     * Get Audios Count
     *
     * @return int
     */
    public function audiosCount();

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if Open Graph is enabled
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Cleans a URL string, then checks to see if a given URL is addressable,
     * returns a 200 OK response, and matches the accepted Internet media types (if provided).
     *
     * @param string $url
     * @param array  $acceptedMimes
     *
     * @return string - cleaned URL string, or empty string on failure.
     */
    public static function isValidUrl($url, array $acceptedMimes = []);

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * A list of allowed page types in the Open Graph Protocol
     *
     * @param bool $flatten - true for grouped types one level deep
     *
     * @return array - Array of Open Graph Protocol object types
     */
    public static function supportedTypes($flatten = false);

    /**
     * Facebook maps languages to a default territory and only accepts locales in this list.
     * A few popular languages such as English and French support multiple territories.
     * Map the Facebook list to avoid throwing errors in Facebook parsers that prevent further content indexing
     *
     * @param bool $keysOnly
     *
     * @return array - associative array of locale code and locale name.
     */
    public static function supportedLocales($keysOnly = false);
}
