<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Traits\VersionableTrait;

class Script
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
    /**
     * Source Path
     *
     * @var string
     */
    protected $src;

    /**
     * True if it's a CDN source
     *
     * @var bool
     */
    protected $cdn = false;

    const TYPE     = 'text/javascript';

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
            $type = ' type="' . self::TYPE . '"';
        }

        return '<script' . $type  . ' src="' . $this->getSrc() . '"></script>';
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
