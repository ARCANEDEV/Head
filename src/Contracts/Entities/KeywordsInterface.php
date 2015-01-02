<?php namespace Arcanedev\Head\Contracts\Entities;

use Arcanedev\Head\Exceptions\InvalidTypeException;

interface KeywordsInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Keywords
     *
     * @return array
     */
    public function get();

    /**
     * Set Keywords
     *
     * @param string|array $keywords
     *
     * @throws InvalidTypeException
     *
     * @return KeywordsInterface
     */
    public function set($keywords);

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render Keywords tag
     *
     * @return string
     */
    public function render();

    /**
     * Get Keywords Count
     *
     * @return int
     */
    public function count();

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if keywords is empty
     *
     * @return bool
     */
    public function isEmpty();
}
