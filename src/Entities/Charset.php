<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\Entities\CharsetInterface;
use Arcanedev\Head\Contracts\Versionable;
use Arcanedev\Head\Exceptions\InvalidTypeException;
use Arcanedev\Head\Traits\VersionableTrait;

/**
 * Class Charset
 * @package Arcanedev\Head\Entities
 */
class Charset extends AbstractMeta implements CharsetInterface, Versionable
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use VersionableTrait;

    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const DEFAULT_CHARSET   = 'UTF-8';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var string
     */
    protected $charset      = '';

    /**
     * @var array
     */
    protected static $supportedCharset = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
        $this->initVersion();

        // Load all supported Charsets
        self::$supportedCharset = function_exists('mb_list_encodings')
            ? mb_list_encodings()
            : $this->getDefaultCharsets();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Charset
     *
     * @return string
     */
    public function get()
    {
        return $this->getCharset();
    }

    /**
     * Get Charset
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->isEmpty() ? $this->getDefault() : $this->charset;
    }

    /**
     * Set Charset
     *
     * @param string $charset
     *
     * @return self
     */
    public function set($charset)
    {
        return $this->setCharset($charset);
    }

    /**
     * Set Charset
     *
     * @param  string $charset
     *
     * @throws InvalidTypeException
     *
     * @return self
     */
    public function setCharset($charset)
    {
        $this->check($charset);
        $this->charset  = $charset;

        return $this;
    }

    /**
     * Get the default Charset
     *
     * @return string
     */
    public function getDefault()
    {
        return self::DEFAULT_CHARSET;
    }

    /**
     * Get all Supported Charsets
     *
     * @return array
     */
    public static function getAllSupportedCharsets()
    {
        return self::$supportedCharset;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a charset
     *
     * @param  string $charset
     *
     * @return Charset
     */
    public static function make($charset)
    {
        return (new self)->setCharset($charset);
    }

    /**
     * Render Charset Tags
     *
     * @return string
     */
    public function render()
    {
        $charset = $this->getCharset();

        return $this->isHTML5()
            ? '<meta charset="' . $charset . '">'
            : '<meta http-equiv="Content-Type" content="text/html; charset=' . $charset . '">';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if Charset is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->charset);
    }

    /**
     * Check Charset
     *
     * @param string $charset
     *
     * @throws InvalidTypeException
     */
    private function check(&$charset)
    {
        if ( ! is_string($charset)) {
            throw new InvalidTypeException('charset', $charset);
        }

        $charset = $this->isSupported($charset)
            ? $this->getFromSupported($charset, true)
            : $this->getDefault();
    }

    /**
     * Check if charset is supported
     *
     * @param  string $charset
     *
     * @return bool
     */
    public static function supported($charset)
    {
        return self::isSupported($charset);
    }

    /**
     * @param string $charset
     *
     * @throws InvalidTypeException
     *
     * @return bool
     */
    private static function isSupported($charset)
    {
        $result = self::getFromSupported($charset);

        return count($result) > 0;
    }

    /**
     * @param string $charset
     * @param bool   $getValue
     *
     * @return array|string
     */
    private static function getFromSupported($charset, $getValue = false)
    {
        $charset = trim($charset);
        $charset = str_replace(' ', '', $charset);
        $result  = array_intersect(self::getAllSupportedCharsets(), [
            $charset,
            strtolower($charset),
            strtoupper($charset)
        ]);

        return $getValue ? reset($result) : $result;
    }

    /**
     * Check if it is HTML5
     *
     * @return bool
     */
    public function isHTML5()
    {
        return $this->version->isHTML5();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get all default charsets
     *
     * @return string[]
     */
    private function getDefaultCharsets()
    {
        return get_default_charsets();
    }
}
