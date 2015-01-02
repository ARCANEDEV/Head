<?php namespace Arcanedev\Head\Contracts\Entities;

use Arcanedev\Head\Exceptions\InvalidTypeException;

interface DescriptionInterface
{
    /* ------------------------------------------------------------------------------------------------
     |   Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Description
     *
     * @return string
     */
    public function get();

    /**
     * Set Description
     *
     * @param string $description
     *
     * @throws InvalidTypeException
     *
     * @return DescriptionInterface
     */
    public function set($description);

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render Description tag
     *
     * @return string
     */
    public function render();

    /* ------------------------------------------------------------------------------------------------
     |  Check function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if description is empty
     *
     * @return bool
     */
    public function isEmpty();

}
