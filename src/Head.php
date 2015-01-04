<?php namespace Arcanedev\Head;

use Arcanedev\Head\Entities\Charset                as Charset;
use Arcanedev\Head\Entities\Title                  as Title;
use Arcanedev\Head\Entities\Description            as Description;
use Arcanedev\Head\Entities\Keywords               as Keywords;
use Arcanedev\Head\Entities\Meta                   as Meta;
use Arcanedev\Head\Entities\MetaCollection         as MetaCollection;
use Arcanedev\Head\Entities\StylesheetCollection   as StylesheetCollection;
use Arcanedev\Head\Entities\ScriptCollection       as ScriptCollection;
use Arcanedev\Head\Entities\OpenGraph\OpenGraph    as OpenGraph;

use Arcanedev\Head\Exceptions\InvalidTypeException as InvalidTypeException;

use Arcanedev\Head\Contracts\HeadInterface         as HeadInterface;
use Arcanedev\Head\Contracts\RenderableInterface   as RenderableInterface;
use Arcanedev\Head\Contracts\VersionableInterface  as VersionableInterface;
use Arcanedev\Head\Traits\VersionableTrait         as VersionableTrait;

class Head implements HeadInterface, RenderableInterface, VersionableInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
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

    /** @var array */
    private $config             = [];

    /** @var string */
    private $publicFolderPath   = "";

    protected $favicon;

    protected $link		        = [];

    /** @var StylesheetCollection */
    protected $styles;

    /** @var ScriptCollection */
    protected $scripts;

    protected $misc		    	= [];

    /** @var OpenGraph */
    protected $openGraph;

    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use VersionableTrait;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct(array $config = [])
    {
        $this->init();

        $this->loadConfig($config);
    }

    /**
     * Init Head
     */
    private function init()
    {
        $this->charset      = new Charset;
        $this->title        = new Title;
        $this->description  = new Description;
        $this->keywords     = new Keywords;
        $this->metas        = new MetaCollection;
        $this->styles  = new StylesheetCollection;
        $this->scripts      = new ScriptCollection;

        $this->openGraph    = new OpenGraph;

        $this->initVersion();
    }

    /**
     * Load Configuration
     *
     * @param array $config
     */
    private function loadConfig($config)
    {
        $this->config = $config;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Charset
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset->get();
    }

    /**
     * Set Charset
     *
     * @param Keywords|string $charset
     *
     * @return Head
     */
    public function setCharset($charset)
    {
        $this->checkCharset($charset);

        if ($charset instanceof Charset) {
            $this->charset = $charset;
        }
        elseif (is_string($charset)) {
            $this->charset->set($charset);
        }

        return $this;
    }

    /**
     * Render Charset Tag
     *
     * @return string
     */
    public function renderCharsetTag()
    {
        return $this->charset->render();
    }

    /**
     * Set SEO Tags
     *
     * @param string       $title
     * @param string       $description
     * @param array|string $keywords
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
     * @return string
     */
    public function getTitle()
    {
        return $this->title->get();
    }

    /**
     * @param Title|string $title
     *
     * @throws InvalidTypeException
     *
     * @return Head
     */
    public function setTitle($title)
    {
        $this->checkTitle($title);

        if ( is_string($title) ) {
            $this->title->set($title);
        }
        elseif ( $title instanceof Title ) {
            $this->title = $title;
        }

        return $this->updateTitleDependencies();
    }

    /**
     * Update Title Dependencies (OpenGraph & Twitter)
     *
     * @return Head
     */
    private function updateTitleDependencies()
    {
        $title      = $this->title->get();
        $siteName   = $this->title->getSiteName();
        $this->openGraph->setTitle($title)->setSiteName($siteName);

        return $this;
    }

    /**
     * Get Title Tag
     *
     * @return string
     */
    public function renderTitleTag()
    {
        return $this->title->render();
    }

    /**
     * Get the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description->get();
    }

    /**
     * @param Description|string $description
     *
     * @throws InvalidTypeException
     *
     * @return Head
     */
    public function setDescription($description)
    {
        $this->checkDescription($description);

        if ( is_string($description) ) {
            $this->description->set($description);
        }
        elseif ( $description instanceof Description ) {
            $this->description = $description;
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
        $description = $this->getDescription();
        $this->openGraph->setDescription($description);

        return $this;
    }

    /**
     * Render Description tag
     *
     * @return string
     */
    public function renderDescriptionTag()
    {
        return $this->description->render();
    }

    /**
     * Get Keywords tags
     *
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords->get();
    }

    /**
     * Set Keywords
     *
     * @param Keywords|string $keywords
     *
     * @throws InvalidTypeException
     *
     * @return Head
     */
    public function setKeywords($keywords)
    {
        $this->checkKeywords($keywords);

        if ( is_string($keywords) or is_array($keywords) ) {
            $this->keywords->set($keywords);
        }

        if ( $keywords instanceof Keywords ) {
            $this->keywords = $keywords;
        }

        return $this;
    }

    /**
     * Render Keywords
     *
     * @return string
     */
    public function renderKeywordsTag()
    {
        return $this->keywords->render();
    }

    /**
     * Get Meta Collection
     *
     * @return MetaCollection
     */
    public function getMetas()
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
     * Render Metas tags
     *
     * @return String
     */
    public function renderMetasTags()
    {
        return $this->metas->render();
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
     * Render Style tags
     *
     * @return String
     */
    public function styles()
    {
        return $this->renderStylesTags();
    }

    /**
     * Render Style tags
     *
     * @return String
     */
    public function renderStylesTags()
    {
        return $this->styles->render();
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

    /**
     * Render Script Tags
     *
     * @return string
     */
    public function scripts()
    {
        return $this->renderScriptsTags();
    }

    /**
     * Render Script Tags
     *
     * @return string
     */
    public function renderScriptsTags()
    {
        return $this->scripts->render();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Facebook / OpenGraph Functions
     | ------------------------------------------------------------------------------------------------
     */
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

    /**
     * Render OpenGraph Tags
     *
     * @return string
     */
    public function renderOpenGraphTags()
    {
        return $this->openGraph->render();
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
        return implode(PHP_EOL, array_filter([
            $this->renderCharsetTag(),
            $this->renderTitleTag(),
            $this->renderDescriptionTag(),
            $this->renderKeywordsTag(),
            $this->renderMetasTags(),
            $this->renderOpenGraphTags(),
            $this->renderStylesTags(),
            $scripts ? $this->renderScriptsTags() : '',
        ]));
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

    /**
     * @param Charset|string $charset
     *
     * @throws InvalidTypeException
     */
    private function checkCharset($charset)
    {
        if (
            ! is_string($charset) and
            ! ($charset instanceof Charset)
        ) {
            throw new InvalidTypeException('charset', $charset, 'string or Charset Object !');
        }
    }

    /**
     * @param $title
     *
     * @throws InvalidTypeException
     */
    private function checkTitle($title)
    {
        if (
            ! is_string($title) and
            ! ($title instanceof Title)
        ) {
            throw new InvalidTypeException('title', $title, 'string or Title Object');
        }
    }

    /**
     * @param $description
     *
     * @throws InvalidTypeException
     */
    private function checkDescription($description)
    {
        if (
            ! is_string($description) and
            ! ($description instanceof Description)
        ) {
            throw new InvalidTypeException('description', $description, 'string or Description Object');
        }
    }

    /**
     * @param $keywords
     *
     * @throws InvalidTypeException
     */
    private function checkKeywords($keywords)
    {
        if (
            ! is_string($keywords) and
            ! is_array($keywords) and
            ! ($keywords instanceof Keywords)
        ) {
            throw new InvalidTypeException('keywords', $keywords, 'string, array or Keywords Object');
        }
    }
}
