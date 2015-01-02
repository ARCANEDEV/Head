<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Support\Collection;

class ScriptCollection extends Collection
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
     * Add a Script
     *
     * @param string $source
     *
     * @return ScriptCollection
     */
    public function add($source)
    {
        $script = Script::make($source);

        $key = $script->getFile();

        if (! $this->has($key) ) {
            $this->put($key, $script);
        }

        return $this;
    }
}
