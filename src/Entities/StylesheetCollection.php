<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Support\Collection;

use Arcanedev\Head\Contracts\Renderable;

class StylesheetCollection extends Collection implements Renderable
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    protected $items;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    function __construct($items = [])
    {
        parent::__construct($items);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add a Stylesheet source
     *
     * @param string $source
     *
     * @return StylesheetCollection
     */
    public function add($source)
    {
        $style = Stylesheet::make($source);

        $key = $style->getFile();

        if (! $this->has($key) ) {
            $this->put($key, $style);
        }

        return $this;
    }

    /**
     * Add many Stylesheet sources
     *
     * @param array $sources
     *
     * @return StylesheetCollection
     */
    public function addMany(array $sources)
    {
        array_map(function($source) {
            $this->add($source);
        }, $sources);

        return $this;
    }

    /**
     * Render all Stylesheets
     *
     * @return string
     */
    public function render()
    {
        $styles = $this->each(function($style) {
            /** @var Stylesheet $style */
            return $style->render();
        })->toArray();

        return implode(PHP_EOL, $styles);
    }
}
