<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\Renderable;
use Arcanedev\Head\Support\Collection;

/**
 * Class ScriptCollection
 * @package Arcanedev\Head\Entities
 */
class ScriptCollection extends Collection implements Renderable
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add a Script
     *
     * @param  string $source
     *
     * @return ScriptCollection
     */
    public function add($source)
    {
        $script = Script::make($source);
        $key    = $script->getFile();

        if ( ! $this->has($key)) {
            $this->put($key, $script);
        }

        return $this;
    }

    /**
     * Add many Scripts
     *
     * @param  array $sources
     *
     * @return ScriptCollection
     */
    public function addMany(array $sources)
    {
        array_map(function($source) {
            $this->add($source);
        }, $sources);

        return $this;
    }

    /**
     * Render all Scripts
     *
     * @return string
     */
    public function render()
    {
        $scripts = $this->each(function($script) {
            /** @var Script $script */
            return $script->render();
        });

        return implode(PHP_EOL, $scripts->toArray());
    }
}
