<?php namespace Arcanedev\Head\Contracts\Entities;

use Arcanedev\Head\Exceptions\InvalidTypeException;

/**
 * Interface CharsetInterface
 * @package Arcanedev\Head\Contracts\Entities
 */
interface CharsetInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Charset
     *
     * @return string
     */
    public function get();

    /**
     * Get Charset
     *
     * @return string
     */
    public function getCharset();

    /**
     * Set Charset
     *
     * @param string $charset
     *
     * @return CharsetInterface
     */
    public function set($charset);

    /**
     * Set Charset
     *
     * @param string $charset
     *
     * @throws InvalidTypeException
     *
     * @return CharsetInterface
     */
    public function setCharset($charset);

    /**
     * Get the default Charset
     *
     * @return string
     */
    public function getDefault();

    /**
     * Get all Supported Charsets
     *
     * @return array
     */
    public static function getAllSupportedCharsets();

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a charset
     *
     * @param string $charset
     *
     * @return CharsetInterface
     */
    public static function make($charset);

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if Charset is empty
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Check if charset is supported
     *
     * @param string $charset
     *
     * @return bool
     */
    public static function supported($charset);

    /**
     * Check if it is HTML5
     *
     * @return bool
     */
    public function isHTML5();
}
