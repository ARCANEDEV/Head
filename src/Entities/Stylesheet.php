<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Traits\VersionableTrait;

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
    protected $src;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
        $this->src = '';
    }

    /**
     * Make a Script
     *
     * @param string $source
     *
     * @return Script
     */
    public static function make($source)
    {
        return (new self)->setSrc($source);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    public function getSrc()
    {
        return $this->src;
    }

    public function setSrc($source)
    {
        $this->src = $source;

        return $this;
    }

    public function getFile()
    {
        if ($this->isEmpty()) {
            return '';
        }

        $elts = explode('/', $this->getSrc());

        return count($elts) > 0 ? end($elts) : '';
    }

    public function getType()
    {
        return self::TYPE;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Function
     | ------------------------------------------------------------------------------------------------
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

        return '<link rel="'. self::REL .'"' . $type  . ' src="' . $this->getSrc() . '">';
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
