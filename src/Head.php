<?php namespace Arcanedev\Head;

use Arcanedev\Head\Contracts\Arrayable;
use Arcanedev\Head\Contracts\HeadInterface;
use Arcanedev\Head\Contracts\Renderable;
use Arcanedev\Head\Contracts\Versionable;
use Arcanedev\Head\Entities\Charset;
use Arcanedev\Head\Entities\Description;
use Arcanedev\Head\Entities\Favicon;
use Arcanedev\Head\Entities\Keywords;
use Arcanedev\Head\Entities\Meta;
use Arcanedev\Head\Entities\MetaCollection;
use Arcanedev\Head\Entities\OpenGraph\OpenGraph;
use Arcanedev\Head\Entities\ScriptCollection;
use Arcanedev\Head\Entities\StylesheetCollection;
use Arcanedev\Head\Entities\Title;
use Arcanedev\Head\Entities\TwitterCard\TwitterCard;
use Arcanedev\Head\Exceptions\FileNotFoundException;
use Arcanedev\Head\Exceptions\InvalidTypeException;
use Arcanedev\Head\Traits\VersionableTrait;
use Arcanedev\Head\Utilities\Config;

// TODO: update HeadInterface
class Head implements HeadInterface, Renderable, Arrayable, Versionable
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use VersionableTrait;

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Config */
    private $config = [];

    /** @var Charset */
    protected $charset;

    /** @var Title */
    private $title;

    /** @var Description */
    private $description;

    /** @var Keywords */
    private $keywords;

    /** @var MetaCollection */
    private $metas;

    /** @var Favicon */
    protected $favicon;

    /** @var StylesheetCollection */
    protected $styles;

    /** @var ScriptCollection */
    protected $scripts;

    /** @var OpenGraph */
    protected $openGraph;

    /** @var TwitterCard */
    protected $twitterCard;

    /** @var array */
    protected $misc = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct(array $config = [])
    {
        $this->setConfig($config);

        $this->init();

        $this->loadEntities();
    }

    /**
     * Init Head
     */
    private function init()
    {
        $this->charset     = new Charset;
        $this->title       = new Title;
        $this->description = new Description;
        $this->keywords    = new Keywords;
        $this->metas       = new MetaCollection;
        $this->favicon     = new Favicon;
        $this->styles      = new StylesheetCollection;
        $this->scripts     = new ScriptCollection;

        $this->openGraph   = new OpenGraph;
        $this->twitterCard = new TwitterCard;

        $this->initVersion();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Config Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Config
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set Configuration
     *
     * @param array $config
     *
     * @return Head
     */
    public function setConfig(array $config = [])
    {
        $this->config = new Config($config);

        return $this;
    }

    /**
     * @param string $path
     *
     * @throws FileNotFoundException
     * @throws InvalidTypeException
     *
     * @return Head
     */
    public function configPath($path)
    {
        $this->config = $this->config->path($path);

        return $this;
    }


    private function loadEntities()
    {
        $this->setCharset($this->config->get('charset', Charset::DEFAULT_CHARSET));
        $this->title->setConfig($this->config->get('title', []));
        $this->favicon->setConfig($this->config->get('favicon', ''));

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Charset
     *
     * @return Charset
     */
    public function charset()
    {
        return $this->charset;
    }

    /**
     * Set Charset
     *
     * @param Charset|string $charset
     *
     * @return Head
     */
    public function setCharset($charset)
    {
        if ($charset instanceof Charset) {
            $this->charset = $charset;
        }
        else {
            $this->charset->set($charset);
        }

        return $this;
    }

    /**
     * Set SEO Tags
     *
     * @param  Title|string          $title
     * @param  Description|string    $description
     * @param  Keywords|array|string $keywords
     *
     * @throws InvalidTypeException
     *
     * @return Head
     */
    public function set($title, $description, $keywords = [])
    {
        return $this->setTitle($title)
                    ->setDescription($description)
                    ->setKeywords($keywords);
    }

    /**
     * Get the Title
     *
     * @return Title
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Get the Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title->get();
    }

    /**
     * Set Title
     *
     * @param Title|string $title
     *
     * @throws InvalidTypeException
     *
     * @return Head
     */
    public function setTitle($title)
    {
        if ($title instanceof Title) {
            $this->title = $title;
        }
        else {
            $this->title->set($title);
        }

        return $this->updateTitleDependencies();
    }

    /**
     * Get Site name
     *
     * @return string
     */
    public function getSiteName()
    {
        return $this->title->getSiteName();
    }

    /**
     * Set Site name
     *
     * @param string $sitename
     *
     * @return Head
     */
    public function setSiteName($sitename)
    {
        $this->title->setSiteName($sitename);

        return $this->updateTitleDependencies();
    }

    /**
     * Update Title Dependencies (OpenGraph & Twitter)
     *
     * @return Head
     */
    private function updateTitleDependencies()
    {
        $this->openGraph->update($this->title);

        return $this;
    }

    /**
     * Get the description
     *
     * @return Description
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param  Description|string $description
     *
     * @throws InvalidTypeException
     *
     * @return Head
     */
    public function setDescription($description)
    {
        if ($description instanceof Description) {
            $this->description = $description;
        }
        else {
            $this->description->set($description);
        }

        return $this->updateDescriptionDependencies();
    }

    /**
     * Update Description Dependencies (OpenGraph & Twitter)
     *
     * @return Head
     */
    private function updateDescriptionDependencies()
    {
        $description = $this->description()->get();
        $this->openGraph->setDescription($description);

        return $this;
    }

    /**
     * Get Keywords
     *
     * @return Keywords
     */
    public function keywords()
    {
        return $this->keywords;
    }

    /**
     * Set Keywords
     *
     * @param Keywords|array|string $keywords
     *
     * @throws InvalidTypeException
     *
     * @return Head
     */
    public function setKeywords($keywords)
    {
        if ($keywords instanceof Keywords) {
            $this->keywords = $keywords;
        }
        else {
            $this->keywords->set($keywords);
        }

        return $this;
    }

    /**
     * Get Meta Collection
     *
     * @return MetaCollection
     */
    public function metas()
    {
        return $this->metas;
    }

    /**
     * Add Meta
     *
     * @param string $name
     * @param string $content
     * @param array  $attributes
     *
     * @return Head
     */
    public function addMeta($name, $content, $attributes = [])
    {
        $this->metas->addMeta($name, $content, $attributes);

        return $this;
    }

    /**
     * Set Meta
     *
     * @param Meta $meta
     *
     * @return Head
     */
    public function setMeta(Meta $meta)
    {
        $this->metas->setMeta($meta);

        return $this;
    }

    /**
     * Render Style tags
     *
     * @return String
     */
    public function styles()
    {
        return $this->styles->render();
    }

    /**
     * Add a Stylesheet
     *
     * @param string $source
     *
     * @return Head
     */
    public function addStyle($source)
    {
        $this->styles->add($source);

        return $this;
    }

    /**
     * Add a Stylesheet
     *
     * @param array $sources
     *
     * @return Head
     */
    public function addStyles(array $sources)
    {
        $this->styles->addMany($sources);

        return $this;
    }

    /**
     * Render Script Tags
     *
     * @return string
     */
    public function scripts()
    {
        return $this->scripts->render();
    }

    /**
     * Add a Javascript file
     *
     * @param string $source
     *
     * @return Head
     */
    public function addScript($source)
    {
        $this->scripts->add($source);

        return $this;
    }

    /**
     * Add many Javascript files
     *
     * @param array $sources
     *
     * @return Head
     */
    public function addScripts(array $sources)
    {
        $this->scripts->addMany($sources);

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Facebook / OpenGraph Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get OpenGraph
     *
     * @return OpenGraph
     */
    public function openGraph()
    {
        return $this->openGraph;
    }

    /**
     * Enable OpenGraph
     *
     * @return Head
     */
    public function doFacebook()
    {
        $this->openGraph->enable();

        return $this;
    }

    /**
     * Disable OpenGraph
     *
     * @return Head
     */
    public function noFacebook()
    {
        $this->openGraph->disable();

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render Head Tags
     *
     * @param bool $scripts
     *
     * @return string
     */
    public function render($scripts = false)
    {
        return implode(PHP_EOL, $this->toArray($scripts));
    }

    /**
     * Get Head Tags array
     *
     * @param bool $scripts
     *
     * @return string
     */
    public function toArray($scripts = false)
    {
        return array_filter([
            $this->charset->render(),
            $this->title->render(),
            $this->description->render(),
            $this->keywords->render(),
            $this->metas->render(),
            $this->openGraph->render(),
            $this->styles->render(),
            $scripts ? $this->scripts->render() : '',
            $this->favicon->render(),
        ]);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if OpenGraph Enabled
     *
     * @return bool
     */
    public function isOpenGraphEnabled()
    {
        return $this->openGraph->isEnabled();
    }
}
