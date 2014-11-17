<?php namespace Arcanedev\Head;

use Arcanedev\Head\Contracts\RenderableInterface    as RenderableInterface;
use Arcanedev\Head\Contracts\VersionableInterface   as VersionableInterface;

use Arcanedev\Head\Entities\Charset                 as Charset;
use Arcanedev\Head\Entities\Title                   as Title;
use Arcanedev\Head\Entities\Description             as Description;
use Arcanedev\Head\Entities\Keywords                as Keywords;
use Arcanedev\Head\Entities\StylesheetCollection    as StylesheetCollection;
use Arcanedev\Head\Entities\ScriptCollection        as ScriptCollection;
use Arcanedev\Head\Entities\MetaCollection          as MetaCollection;

use Arcanedev\Head\Exceptions\InvalidTypeException  as InvalidTypeException;

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

    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use \Arcanedev\Head\Traits\VersionableTrait;

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

        return $this;
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

        return $this;
    }

    /**
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

        if ( $keywords instanceof Description ) {
            $this->keywords = $keywords;
        }

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */

    public function render()
    {
        $tags = [
            $this->charset->render(),
            $this->title->render(),
            $this->description->render(),
            $this->keywords->render(),
        ];

        return implode(PHP_EOL, array_filter($tags));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param $title
     *
     * @throws InvalidTypeException
     */
    private function checkTitle($title)
    {
        if ( ! is_string($title) and ! ($title instanceof Title) ) {
            throw new InvalidTypeException('title', $title, 'string or Title Class');
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
            throw new InvalidTypeException('description', $description, 'string or Description Class');
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
            throw new InvalidTypeException('keywords', $keywords, 'string, array or Keywords Class');
        }
    }
}
