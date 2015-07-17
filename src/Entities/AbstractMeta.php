<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Markup\Markup;

/**
 * Class AbstractMeta
 * @package Arcanedev\Head\Entities
 */
abstract class AbstractMeta
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return string
     */
    abstract public function render();

    /**
     * Render meta tag
     *
     * @param  string $name
     * @param  string $content
     * @param  array  $attributes
     *
     * @return string
     */
    protected function renderMetaTag($name, $content, array $attributes = [])
    {
        if ($this->isEmpty()) {
            return '';
        }

        return Markup::meta('name', $name, $content, $attributes)->render();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check is empty
     *
     * @return bool
     */
    abstract public function isEmpty();
}
