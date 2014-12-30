<?php namespace Arcanedev\Head;

use Arcanedev\Head\Contracts\RenderableInterface   as RenderableInterface;
use Arcanedev\Head\Contracts\VersionableInterface  as VersionableInterface;

use Arcanedev\Head\Entities\Charset                as Charset;
use Arcanedev\Head\Entities\OpenGraph\OpenGraph    as OpenGraph;
use Arcanedev\Head\Entities\Title                  as Title;
use Arcanedev\Head\Entities\Description            as Description;
use Arcanedev\Head\Entities\Keywords               as Keywords;
use Arcanedev\Head\Entities\StylesheetCollection   as StylesheetCollection;
use Arcanedev\Head\Entities\ScriptCollection       as ScriptCollection;
use Arcanedev\Head\Entities\MetaCollection         as MetaCollection;

use Arcanedev\Head\Traits\VersionableTrait         as VersionableTrait;

use Arcanedev\Head\Exceptions\InvalidTypeException as InvalidTypeException;

class Head implements RenderableInterface, VersionableInterface
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
    protected $stylesheets;

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

    private function init()
    {
        $this->charset      = new Charset;
        $this->title        = new Title;
        $this->description  = new Description;
        $this->keywords     = new Keywords;
        $this->metas        = new MetaCollection;
        $this->stylesheets  = new StylesheetCollection;
        $this->scripts      = new ScriptCollection;

        $this->openGraph    = new OpenGraph;

        $this->initVersion();
    }

    /**
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
     * @return string
     */
    public function getCharset()
    {
        return $this->charset->get();
    }

    /**
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
     * @return string
     */
    public function getCharsetTag()
    {
        return $this->charset->render();
    }

    /**
     * @param       string $title
     * @param       string $description
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

        $this->updateTitleDependencies();

        return $this;
    }

    private function updateTitleDependencies()
    {
        $title      = $this->title->get();
        $siteName   = $this->title->getSiteName();
        $this->openGraph->setTitle($title)->setSiteName($siteName);
    }

    /**
     * Get Title Tag
     *
     * @return string
     */
    public function getTitleTag()
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

        $this->updateDescriptionDependencies();

        return $this;
    }

    private function updateDescriptionDependencies()
    {
        $description = $this->getDescription();
        $this->openGraph->setDescription($description);
    }

    /**
     * @return string
     */
    public function getDescriptionTag()
    {
        return $this->description->render();
    }

    /**
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
     * @return string
     */
    public function getKeywordsTag()
    {
        return $this->keywords->render();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Facebook / OpenGraph Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function doFacebook()
    {
        $this->openGraph->enable();

        return $this;
    }

    public function noFacebook()
    {
        $this->openGraph->disable();

        return $this;
    }

    private function getOpenGraphTags()
    {
        return $this->openGraph->render();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function render()
    {
        $tags = [
            $this->getCharsetTag(),
            $this->getTitleTag(),
            $this->getDescriptionTag(),
            $this->getKeywordsTag(),
            $this->getOpenGraphTags(),
        ];

        return implode(PHP_EOL, array_filter($tags));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param Charset|string $charset
     *
     * @throws InvalidTypeException
     */
    private function checkCharset($charset)
    {
        if ( ! is_string($charset) and ! ($charset instanceof Charset) ) {
            throw new InvalidTypeException('charset', $charset, 'string or Charset Object');
        }
    }

    /**
     * @param $title
     *
     * @throws InvalidTypeException
     */
    private function checkTitle($title)
    {
        if ( ! is_string($title) and ! ($title instanceof Title) ) {
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
        if ( ! is_string($description) and !($description instanceof Description) ) {
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
        if ( ! is_string($keywords) and ! is_array($keywords) and ! ($keywords instanceof Keywords) ) {
            throw new InvalidTypeException('keywords', $keywords, 'string, array or Keywords Object');
        }
    }
}
