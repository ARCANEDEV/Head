<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\Renderable;
use Arcanedev\Markup\Markup;

/**
 * Class Favicon
 * @package Arcanedev\Head\Entities
 */
class Favicon implements Renderable
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $icon = '';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct($icon = '')
    {
        $this->setIcon($icon);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set Favicon config
     *
     * @param  string $icon
     *
     * @return Favicon
     */
    public function setIcon($icon = '')
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon type favicon path
     *
     * @return string
     */
    private function getIconPath()
    {
        return $this->getPath('ico');
    }

    /**
     * Get image type favicon path
     *
     * @return string
     */
    private function getImagePath()
    {
        return $this->getPath('png');
    }

    /**
     * Get favicon path
     *
     * @param  string $extension
     *
     * @return string
     */
    private function getPath($extension)
    {
        return base_url($this->icon . '.' . $extension);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render
     *
     * @return string
     */
    public function render()
    {
        return implode(PHP_EOL, $this->toArray());
    }

    /**
     * @return array
     */
    public function toArray()
    {
        if ($this->isEmpty()) {
            return [];
        }

        $tags = [];

        // Check if .ico file exists
        //if ($this->isFaviconExists('ico')) {
        $tags[] = [
            'href' => $this->getIconPath(),
            'rel'  => 'icon',
            'type' => 'image/x-icon'
        ];
        //}

        // Check if .png file exists
        // if ($this->isFaviconExists('png')) {
        $tags[] = [
            'href' => $this->getImagePath(),
            'rel'  => 'icon',
            'type' => 'image/png'
        ];
        // }

        $tags = array_map(function($attributes) {
            return Markup::make('link', $attributes)->render();
        }, $tags);

        return array_filter($tags);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if icon is set
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->icon);
    }
}
