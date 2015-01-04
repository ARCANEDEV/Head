<?php namespace Arcanedev\Head\Entities\OpenGraph;

use Arcanedev\Head\Entities\OpenGraph\Medias\AudioMedia;
use Arcanedev\Head\Entities\OpenGraph\Medias\ImageMedia;
use Arcanedev\Head\Entities\OpenGraph\Medias\VideoMedia;

use Arcanedev\Head\Contracts\Entities\OpenGraphInterface;
use Arcanedev\Head\Contracts\RenderableInterface;

class OpenGraph implements OpenGraphInterface, RenderableInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Version
     *
     * @var string
     */
    const VERSION = '1.3';

    /**
     * Should we remotely request each referenced URL to make sure it exists and returns the expected Internet media type?
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
     */
    // TODO: Change this to ImageCollection
    protected $images;

    /**
     * An array of OpenGraphProtocolAudio objects
     *
     * @var array
     */
    // TODO: Change this to AudioCollection
    protected $audios;

    /**
     * An array of OpenGraphProtocolVideo objects
     *
     * @var array
     */
    // TODO: Change this to VideoCollection
    protected $videos;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
        // TODO: Implement __construct() method.
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
            is_string($type) and
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
     * @param string $title
     *
     * @return OpenGraph
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
     * @param string $siteName
     *
     * @return OpenGraph
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
     * @return OpenGraph
     */
    public function setDescription($description)
    {
        if (is_string($description) and ! empty($description)) {
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
     * @param string $url
     *
     * @return OpenGraph
     */
    public function setURL($url)
    {
        if (! is_string($url) or empty($url)) {
            return $this;
        }

        $url = trim($url);

        if (self::VERIFY_URLS) {
            $url = self::isValidUrl($url, [
                'text/html', 'application/xhtml+xml'
            ]);
        }

        if (! empty($url)) {
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
     * @param string $determiner
     *
     * @return OpenGraph
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
     * @var string $locale
     *
     * @return OpenGraph
     */
    public function setLocale($locale)
    {
        if (
            is_string($locale) and
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
     * @param ImageMedia $image
     *
     * @return OpenGraph
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
     * @param string     $imageUrl
     * @param ImageMedia $image
     *
     * @return $this
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
     * @param VideoMedia $video
     *
     * @return OpenGraph
     */
    public function addVideo(VideoMedia $video)
    {
        $video_url = $video->getURL();

        if (empty($video_url)) {
            return $this;
        }

        $video->removeURL();
        $value = [$video_url, [$video]];

        if (! isset($this->videos)) {
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
     * @param AudioMedia $audio
     *
     * @return OpenGraph
     */
    public function addAudio(AudioMedia $audio)
    {
        $audio_url = $audio->getURL();

        if (empty($audio_url)) {
            return '';
        }

        $audio->removeURL();
        $value = [$audio_url, [$audio]];

        if (! isset($this->audios)) {
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
     * Enable OpenGraph
     *
     * @return OpenGraph
     */
    public function enable()
    {
        return $this->setEnabled(true);
    }

    /**
     * Disable OpenGraph
     *
     * @return OpenGraph
     */
    public function disable()
    {
        return $this->setEnabled(false);
    }

    /**
     * Set OpenGraph to Enable/Disable
     *
     * @param bool $enabled
     *
     * @return OpenGraph
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
        return $this->isEnabled() ? $this->toHTML() : '';
    }

    /**
     * Output the OpenGraphProtocol object as HTML elements string
     *
     * @return string meta elements
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
     * @param string $url
     * @param array  $acceptedMimes
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

        return self::curlParsedURL($url, $acceptedMimes);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * CURL Parsed URL
     *
     * @param       $url
     * @param array $acceptedMimes
     *
     * @return string
     */
    private static function curlParsedURL($url, array $acceptedMimes)
    {
        /*
         * Validate URI string by letting PHP break up the string and put it back together again
         * Excludes username:password and port number URI parts
         */
        $url = self::parseUrl($url);

        if (empty($url)) {
            return $url;
        }

        // test if URL exists
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_NOBODY, true); // HEAD
        curl_setopt($ch, CURLOPT_USERAGENT, 'Open Graph protocol validator ' . self::VERSION . ' (+http://ogp.me/)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (! empty($acceptedMimes)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: ' . implode(',', $acceptedMimes)]);
        }

        $response       = curl_exec($ch);
        $statusCode     = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($statusCode != 200 or empty($acceptedMimes)) {
            return '';
        }

        if ($statusCode == 200 and ! empty($acceptedMimes)) {
            $contentType    = explode(';', curl_getinfo($ch, CURLINFO_CONTENT_TYPE));

            if (
                empty($contentType) or
                ! in_array($contentType[0], $acceptedMimes)
            ) {
                return '';
            }
        }

        unset($response);

        return $url;
    }

    /**
     * Parse URL
     *
     * @param string $url
     *
     * @return string
     */
    private static function parseUrl($url)
    {
        $urlParts   = parse_url($url);

        $url        = '';

        if (
            isset($urlParts['scheme']) and
            in_array($urlParts['scheme'], ['http', 'https'], true)
        ) {
            $url  = $urlParts['scheme'] . "://";
            $url .= $urlParts['host'];
            $url .= isset($urlParts['path']) ? $urlParts['path'] : '';

            if (! isset($urlParts['path']) or empty($urlParts['path'])) {
                $url .= '/';
            }

            if (! empty($urlParts['query'])) {
                $url .= '?' . $urlParts['query'];
            }

            if (! empty($urlParts['fragment'])) {
                $url .= '#' . $urlParts['fragment'];
            }
        }

        return $url;
    }

    /**
     * A list of allowed page types in the Open Graph Protocol
     *
     * @param bool $flatten - true for grouped types one level deep
     *
     * @return array - Array of Open Graph Protocol object types
     */
    public static function supportedTypes($flatten = false)
    {
        $types = [
            _('Activities') => [
                'activity'              => _('Activity'),
                'sport'                 => _('Sport')
            ],
            _('Businesses') => [
                'company'               => _('Company'),
                'bar'                   => _('Bar'),
                'cafe'                  => _('Cafe'),
                'hotel'                 => _('Hotel'),
                'restaurant'            => _('Restaurant')
            ],
            _('Groups') => [
                'cause'                 => _('Cause'),
                'sports_league'         => _('Sports league'),
                'sports_team'           => _('Sports team')
            ],
            _('Organizations')  => [
                'band'                  => _('Band'),
                'government'            => _('Government'),
                'non_profit'            => _('Non-profit'),
                'school'                => _('School'),
                'university'            => _('University')
            ],
            _('People') => [
                'actor'                 => _('Actor or actress'),
                'athlete'               => _('Athlete'),
                'author'                => _('Author'),
                'director'              => _('Director'),
                'musician'              => _('Musician'),
                'politician'            => _('Politician'),
                'profile'               => _('Profile'),
                'public_figure'         => _('Public Figure')
            ],
            _('Places') => [
                'city'                  => _('City or locality'),
                'country'               => _('Country'),
                'landmark'              => _('Landmark'),
                'state_province'        => _('State or province')
            ],
            _('Products and Entertainment') => [
                'music.album'           => _('Music Album'),
                'book'                  => _('Book'),
                'drink'                 => _('Drink'),
                'video.episode'         => _('Video episode'),
                'food'                  => _('Food'),
                'game'                  => _('Game'),
                'video.movie'           => _('Movie'),
                'music.playlist'        => _('Music playlist'),
                'product'               => _('Product'),
                'music.radio_station'   => _('Radio station'),
                'music.song'            => _('Song'),
                'video.tv_show'         => _('Television show'),
                'video.other'           => _('Video')
            ],
            _('Websites') => [
                'article'               => _('Article'),
                'blog'                  => _('Blog'),
                'website'               => _('Website')
            ]
        ];

        if ($flatten === false) {
            return $types;
        }

        $typesValues = [];

        foreach ($types as $category => $values) {
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
        $locales = [
            'af_ZA' => _('Afrikaans'),
            'ar_AR' => _('Arabic'),
            'az_AZ' => _('Azeri'),
            'be_BY' => _('Belarusian'),
            'bg_BG' => _('Bulgarian'),
            'bn_IN' => _('Bengali'),
            'bs_BA' => _('Bosnian'),
            'ca_ES' => _('Catalan'),
            'cs_CZ' => _('Czech'),
            'cy_GB' => _('Welsh'),
            'da_DK' => _('Danish'),
            'de_DE' => _('German'),
            'el_GR' => _('Greek'),
            'en_GB' => _('English (UK)'),
            'en_US' => _('English (US)'),
            'eo_EO' => _('Esperanto'),
            'es_ES' => _('Spanish (Spain)'),
            'es_LA' => _('Spanish (Latin America)'),
            'et_EE' => _('Estonian'),
            'eu_ES' => _('Basque'),
            'fa_IR' => _('Persian'),
            'fi_FI' => _('Finnish'),
            'fo_FO' => _('Faroese'),
            'fr_CA' => _('French (Canada)'),
            'fr_FR' => _('French (France)'),
            'fy_NL' => _('Frisian'),
            'ga_IE' => _('Irish'),
            'gl_ES' => _('Galician'),
            'he_IL' => _('Hebrew'),
            'hi_IN' => _('Hindi'),
            'hr_HR' => _('Croatian'),
            'hu_HU' => _('Hungarian'),
            'hy_AM' => _('Armenian'),
            'id_ID' => _('Indonesian'),
            'is_IS' => _('Icelandic'),
            'it_IT' => _('Italian'),
            'ja_JP' => _('Japanese'),
            'ka_GE' => _('Georgian'),
            'ko_KR' => _('Korean'),
            'ku_TR' => _('Kurdish'),
            'la_VA' => _('Latin'),
            'lt_LT' => _('Lithuanian'),
            'lv_LV' => _('Latvian'),
            'mk_MK' => _('Macedonian'),
            'ml_IN' => _('Malayalam'),
            'ms_MY' => _('Malay'),
            'nb_NO' => _('Norwegian (bokmal)'),
            'ne_NP' => _('Nepali'),
            'nl_NL' => _('Dutch'),
            'nn_NO' => _('Norwegian (nynorsk)'),
            'pa_IN' => _('Punjabi'),
            'pl_PL' => _('Polish'),
            'ps_AF' => _('Pashto'),
            'pt_PT' => _('Portuguese (Brazil)'),
            'ro_RO' => _('Romanian'),
            'ru_RU' => _('Russian'),
            'sk_SK' => _('Slovak'),
            'sl_SI' => _('Slovenian'),
            'sq_AL' => _('Albanian'),
            'sr_RS' => _('Serbian'),
            'sv_SE' => _('Swedish'),
            'sw_KE' => _('Swahili'),
            'ta_IN' => _('Tamil'),
            'te_IN' => _('Telugu'),
            'th_TH' => _('Thai'),
            'tl_PH' => _('Filipino'),
            'tr_TR' => _('Turkish'),
            'uk_UA' => _('Ukrainian'),
            'vi_VN' => _('Vietnamese'),
            'zh_CN' => _('Simplified Chinese (China)'),
            'zh_HK' => _('Traditional Chinese (Hong Kong)'),
            'zh_TW' => _('Traditional Chinese (Taiwan)')
        ];

        return ( $keysOnly === true )
            ? array_keys($locales)
            : $locales;
    }
}
