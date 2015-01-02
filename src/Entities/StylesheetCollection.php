<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Support\Collection;

class StylesheetCollection extends Collection
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
    public function add($source)
    {
        $style = Stylesheet::make($source);

        $key = $style->getFile();

        if (! $this->has($key) ) {
            $this->put($key, $style);
        }

        return $this;
    }
}
