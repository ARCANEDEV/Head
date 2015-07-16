<?php namespace Arcanedev\Head\Contracts;

/**
 * Interface Renderable
 * @package Arcanedev\Head\Contracts
 */
interface Renderable
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render the entity
     *
     * @return string
     */
    public function render();
}
