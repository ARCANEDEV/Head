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
     * @param string $name
     * @param string $content
     *
     * @return string
     */
    protected function renderMetaTag($name, $content)
    {
        return ! $this->isEmpty()
            ? Markup::meta('name', $name, $content)->render()
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
