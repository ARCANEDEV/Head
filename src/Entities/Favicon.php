<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\Renderable;
use Arcanedev\Markup\Markup;

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
    public function __construct()
    {
        $this->icon = '';
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
    public function setConfig($icon = '')
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
    public function render()
    {
        return implode(PHP_EOL, $this->toArray());
    }

    public function toArray()
    {
        $tags = [];

        if ( ! $this->isEmpty()) {
            // Check if .ico file exists
            // if ($this->isFaviconExists('ico')) {
            $tags[] = [
                'href' => $this->getIconPath(),
                'rel'  => 'icon',
                'type' => 'image/x-icon'
            ];
            // }

            // Check if .png file exists
            // if ($this->isFaviconExists('png')) {
            $tags[] = [
                'href' => $this->getImagePath(),
                'rel'  => 'icon',
                'type' => 'image/png'
            ];
            // }
        }

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

    /**
     * Check if favicon exists
     *
     * @param  string $extension
     *
     * @return bool
     */
    private function isFaviconExists($extension = 'ico')
    {
        $headers = @get_headers($this->getPath($extension));

        return strpos($headers[0], '200') !== false;
    }
}
