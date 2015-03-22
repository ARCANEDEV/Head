<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Markup\Markup;

abstract class AbstractMeta
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return string
     */
    abstract public function render();

    /**
     * @param  string $name
     * @param  string $content
     * @param  array  $attributes
     *
     * @return string
     */
    protected function renderMetaTag($name, $content, array $attributes = [])
    {
        return ! $this->isEmpty()
            ? Markup::meta('name', $name, $content, $attributes)->render()
            : '';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return bool
     */
    abstract public function isEmpty();
}
