<?php namespace Arcanedev\Head\Entities;

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
            ? '<meta name="' . $name . '" content="' . $content . '">'
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
