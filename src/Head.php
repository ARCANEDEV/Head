<?php namespace Arcanedev\Head;

use Arcanedev\Head\Entities\Title                   as Title;
use Arcanedev\Head\Entities\Description             as Description;
use Arcanedev\Head\Entities\Keywords                as Keywords;
use Arcanedev\Head\Entities\MetaCollection          as MetaCollection;

use Arcanedev\Head\Exceptions\InvalidTypeException  as InvalidTypeException;

class Head
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var Title
     */
    private $title;

    /**
     * @var Description
     */
    private $description;

    /**
     * @var Keywords
     */
    private $keywords;

    /**
     * @var MetaCollection
     */
    private $metas;
    /**
     * @var array
     */
    private $config = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct(array $config = [])
    {
        $this->title        = new Title;
        $this->description  = new Description;
        $this->keywords     = new Keywords;
        $this->metas        = new MetaCollection;

        // Load config
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
        if ( ! is_string($title) and ! ($title instanceof Title) ) {
            throw new InvalidTypeException('title', $title, 'string or Title Class');
        }

        if ( is_string($title) ) {
            $this->title->set($title);
        }

        if ( $title instanceof Title ) {
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
        if ( ! is_string($description) and ! ($description instanceof Description) ) {
            throw new InvalidTypeException('description', $description, 'string or Description Class');
        }

        if ( is_string($description) ) {
            $this->description->set($description);
        }

        if ( $description instanceof Description ) {
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
        if ( ! is_string($keywords) and ! is_array($keywords) and ! ($keywords instanceof Keywords) ) {
            throw new InvalidTypeException('keywords', $keywords, 'string, array or Keywords Class');
        }

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
            $this->title->render(),
            $this->description->render(),
            $this->keywords->render(),
        ];

        return implode(PHP_EOL, array_filter($tags));
    }
}
