<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Traits\VersionableTrait;

/**
 * Class Stylesheet
 * @package Arcanedev\Head\Entities
 */
class Stylesheet
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use VersionableTrait;

    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const TYPE = 'text/css';
    const REL  = 'stylesheet';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Style source path
     *
     * @var string
     */
    protected $src;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
        $this->src = '';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get src path
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set src path
     *
     * @param  string $source
     *
     * @return self
     */
    public function setSrc($source)
    {
        $this->src = $source;

        return $this;
    }

    /**
     * Get file
     *
     * @return mixed|string
     */
    public function getFile()
    {
        if ($this->isEmpty()) {
            return '';
        }

        $elts = explode('/', $this->getSrc());

        return count($elts) > 0 ? end($elts) : '';
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return self::TYPE;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a style
     *
     * @param  string $source
     *
     * @return Script
     */
    public static function make($source)
    {
        return (new self)->setSrc($source);
    }

    /**
     * Render
     *
     * @return string
     */
    public function render()
    {
        if ($this->isEmpty()) {
            return '';
        }

        $type = '';

        if (! $this->isHTML5()) {
            $type = ' type="' . $this->getType() . '"';
        }

        return '<link rel="'. self::REL .'"' . $type  . ' href="' . $this->getSrc() . '">';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if Src is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->src);
    }
}
