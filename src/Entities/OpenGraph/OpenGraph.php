<?php namespace Arcanedev\Head\Entities\OpenGraph;

use Arcanedev\Head\Contracts\Entities\OpenGraphInterface;
use Arcanedev\Head\Contracts\Renderable;
use Arcanedev\Head\Entities\OpenGraph\Medias\AudioMedia;
use Arcanedev\Head\Entities\OpenGraph\Medias\ImageMedia;
use Arcanedev\Head\Entities\OpenGraph\Medias\VideoMedia;
use Arcanedev\Head\Entities\Title;

/**
 * Class OpenGraph
 * @package Arcanedev\Head\Entities\OpenGraph
 */
class OpenGraph implements OpenGraphInterface, Renderable
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Should we remotely request each referenced URL to make sure it exists and returns
     * the expected Internet media type?
     *
     * @var bool
     */
    const VERIFY_URLS  = false;

    /** @var bool */
    protected $enabled = false;

    /**
     * Page classification according to a pre-defined set of base types.
     *
     * @var string
     */
    protected $type;

    /**
     * The title of your object as it should appear within the graph.
     *
     * @var string
     */
    protected $title;

    /**
     * If your object is part of a larger web site, the name which should be displayed for the overall site.
     *
     * @var string
     */
    protected $site_name;

    /**
     * A one to two sentence description of your object.
     *
     * @var string
     */
    protected $description;

    /**
     * The canonical URL of your object that will be used as its permanent ID in the graph.
     *
     * @var string
     */
    protected $url;

    /**
     * The word that appears before this object's title in a sentence
     *
     * @var string
     */
    protected $determiner;

    /**
     * Language and optional territory of page content.
     *
     * @var string
     */
    protected $locale;

    /**
     * An array of OpenGraphProtocolImage objects
     *
     * @var array
     * @TODO: Change this to ImageCollection
     */
    protected $images;

    /**
     * An array of OpenGraphProtocolAudio objects
     *
     * @var array
     * @TODO: Change this to AudioCollection
     */
    protected $audios;

    /**
     * An array of OpenGraphProtocolVideo objects
     *
     * @var array
     * @TODO: Change this to VideoCollection
     */
    protected $videos;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the Type slug
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the Type slug
     *
     * @param string $type
     *
     * @return OpenGraph
     */
    public function setType($type)
    {
        if (
            is_string($type) &&
            in_array($type, self::supportedTypes(true), true)
        ) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set Title
     *
     * @param  string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        if (is_string($title)) {
            $title = trim($title);

            if (strlen($title) > 128) {
                $title = substr($title, 0, 128);
            }

            $this->title = $title;
        }

        return $this;
    }

    /**
     * Get Site name
     *
     * @return string
     */
    public function getSiteName()
    {
        return $this->site_name;
    }

    /**
     * Set Site name
     *
     * @param  string $siteName
     *
     * @return self
     */
    public function setSiteName($siteName)
    {
        if (is_string($siteName) and ! empty($siteName)) {
            $siteName = trim($siteName);

            if (strlen($siteName) > 128) {
                $siteName = substr($siteName, 0, 128);
            }

            $this->site_name = $siteName;
        }

        return $this;
    }

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Description
     *
     * @param string $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        if (is_string($description) && ! empty($description)) {
            $description = trim( $description );

            if (strlen($description) > 255) {
                $description = substr($description, 0, 255);
            }

            $this->description = $description;
        }

        return $this;
    }

    /**
     * Get URL
     *
     * @return string
     */
    public function getURL()
    {
        return $this->url;
    }

    /**
     * Set the Canonical URL
     *
     * @param  string $url
     *
     * @return self
     */
    public function setURL($url)
    {
        if ( ! is_string($url) || empty($url)) {
            return $this;
        }

        $url = trim($url);

        if (self::VERIFY_URLS) {
            $url = self::isValidUrl($url, [
                'text/html', 'application/xhtml+xml'
            ]);
        }

        if ( ! empty($url)) {
            $this->url = $url;
        }

        return $this;
    }

    /**
     * Get the determiner
     *
     * @return string
     */
    public function getDeterminer()
    {
        return $this->determiner;
    }

    /**
     * Set the determiner
     *
     * @param  string $determiner
     *
     * @return self
     */
    public function setDeterminer($determiner)
    {
        if (in_array($determiner, ['a', 'an', 'auto', 'the'], true)) {
            $this->determiner = $determiner;
        }

        return $this;
    }

    /**
     * Get the locale (language_TERRITORY)
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set locale in the format (language_TERRITORY)
     *
     * @param  string $locale
     *
     * @return self
     */
    public function setLocale($locale)
    {
        if (
            is_string($locale) &&
            in_array($locale, self::supportedLocales(true))
        ) {
            $this->locale = $locale;
        }

        return $this;
    }

    /**
     * Get ImageMedia array
     *
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add an image.
     * The first image added is given priority by the Open Graph Protocol spec.
     * Implementors may choose a different image based on size requirements or preferences.
     *
     * @param  ImageMedia $image
     *
     * @return self
     */
    public function addImage(ImageMedia $image)
    {
        $imageUrl = $image->getURL();

        if (! empty($imageUrl)) {
            $image->removeURL();

            $this->addImageToCollection($imageUrl, $image);
        }

        return $this;
    }

    /**
     * Add ImageMedia to Collection
     *
     * @param  string     $imageUrl
     * @param  ImageMedia $image
     *
     * @return self
     */
    private function addImageToCollection($imageUrl, ImageMedia $image)
    {
        $value = [$imageUrl, [$image]];

        if (! ($this->imagesCount() > 0)) {
            $this->images    = [$value];
        }
        else {
            $this->images[]  = $value;
        }

        return $this;
    }

    /**
     * Get VideoMedia array
     *
     * @return array
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Add a video reference
     * The first video is given priority by the Open Graph protocol spec.
     * Implementors may choose a different video based on size requirements or preferences.
     *
     * @param  VideoMedia $video
     *
     * @return self
     */
    public function addVideo(VideoMedia $video)
    {
        $video_url = $video->getURL();

        if (empty($video_url)) {
            return $this;
        }

        $video->removeURL();
        $value = [$video_url, [$video]];

        if ( ! isset($this->videos)) {
            $this->videos = [$value];
        }
        else {
            $this->videos[] = $value;
        }

        return $this;
    }

    /**
     * Get AudioMedia array
     *
     * @return array
     */
    public function getAudios()
    {
        return $this->audios;
    }

    /**
     * Add an audio reference
     * The first audio is given priority by the Open Graph protocol spec.
     *
     * @param  AudioMedia $audio
     *
     * @return self|string
     */
    public function addAudio(AudioMedia $audio)
    {
        $audio_url = $audio->getURL();

        if (empty($audio_url)) {
            return '';
        }

        $audio->removeURL();
        $value = [$audio_url, [$audio]];

        if ( ! isset($this->audios)) {
            $this->audios = [$value];
        }
        else {
            $this->audios[] = $value;
        }

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Update the title
     *
     * @param  Title $title
     *
     * @return self
     */
    public function update(Title $title)
    {
        $this->setTitle($title->getTitle())
             ->setSiteName($title->getSiteName());

        return $this;
    }

    /**
     * Enable OpenGraph
     *
     * @return self
     */
    public function enable()
    {
        return $this->setEnabled(true);
    }

    /**
     * Disable OpenGraph
     *
     * @return self
     */
    public function disable()
    {
        return $this->setEnabled(false);
    }

    /**
     * Set OpenGraph to Enable/Disable
     *
     * @param  bool $enabled
     *
     * @return self
     */
    private function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Render OpenGraph
     *
     * @return string
     */
    public function render()
    {
        if ( ! $this->isEnabled()) {
            return '';
        }

        return $this->toHTML();
    }

    /**
     * Output the OpenGraphProtocol object as HTML elements string
     *
     * @return string
     */
    private function toHTML()
    {
        $allowed    = array_flip([
            'type',
            'title',
            'site_name',
            'description',
            'url',
            'determiner',
            'locale',
            'images',
            'videos',
            'audios'
        ]);

        $attributes = array_intersect_key(get_object_vars($this), $allowed);

        return OGMetaBuilder::html($attributes);
    }

    /**
     * Get Images Count
     *
     * @return int
     */
    public function imagesCount()
    {
        $images = $this->getImages();

        return isset($images) ? count($images) : 0;
    }

    /**
     * Get Videos Count
     *
     * @return int
     */
    public function videosCount()
    {
        $videos = $this->getVideos();

        return isset($videos) ? count($videos) : 0;
    }

    /**
     * Get Audios Count
     *
     * @return int
     */
    public function audiosCount()
    {
        $audios = $this->getAudios();

        return isset($audios) ? count($audios) : 0;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if Open Graph is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Cleans a URL string, then checks to see if a given URL is addressable,
     * returns a 200 OK response, and matches the accepted Internet media types (if provided).
     *
     * @param  string   $url
     * @param  string[] $acceptedMimes
     *
     * @return string - cleaned URL string, or empty string on failure.
     */
    public static function isValidUrl($url, array $acceptedMimes = [])
    {
        if (! is_string($url) or empty($url)) {
            return '';
        }

        if (empty($acceptedMimes)) {
            $acceptedMimes = [
                'text/html', 'application/xhtml+xml'
            ];
        }

        return Requestor::run($url, $acceptedMimes);
    }

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
    public static function supportedTypes($flatten = false)
    {
        $types = get_og_types();

        if ($flatten === false) {
            return $types;
        }

        $typesValues = [];

        foreach ($types as $values) {
            $typesValues = array_merge($typesValues, array_keys($values));
        }

        return $typesValues;
    }

    /**
     * Facebook maps languages to a default territory and only accepts locales in this list.
     * A few popular languages such as English and French support multiple territories.
     * Map the Facebook list to avoid throwing errors in Facebook parsers that prevent further content indexing
     *
     * @param bool $keysOnly
     *
     * @return array - associative array of locale code and locale name.
     */
    public static function supportedLocales($keysOnly = false)
    {
        $locales = get_supported_locales();

        return $keysOnly === true ? array_keys($locales) : $locales;
    }
}
