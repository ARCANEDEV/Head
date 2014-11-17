<?php namespace Arcanedev\Head\Support;

use Arcanedev\Head\Exceptions\Exception;
use Arcanedev\Head\Exceptions\InvalidHTMLVersionException;
use Arcanedev\Head\Exceptions\InvalidTypeException;

class HTMLVersion
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    protected $version      = '';

    private $supported      = ['4', '5'];

    const DEFAULT_VERSION   = '5';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
        // TODO: Implement __construct() method.
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return string
     */
    public function get()
    {
        if ( $this->isEmpty() ) {
            $this->set(self::DEFAULT_VERSION);
        }

        return $this->version;
    }

    /**
     * @param string|HTMLVersion $version
     *
     * @throws InvalidTypeException
     * @throws InvalidHTMLVersionException
     *
     * @return HTMLVersion
     */
    public function set($version)
    {
        if ( $version instanceof HTMLVersion) {
            $version = $version->get();
        }

        $this->check($version);

        $this->version = $version;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->version);
    }

    /**
     * @param string $version
     *
     * @return bool
     */
    public function isSupported($version)
    {
        return in_array($version, $this->supported);
    }

    /**
     * @return bool
     */
    public function isHTML5()
    {
        return $this->get() === '5';
    }

    /**
     * @param string $version
     *
     * @throws Exception
     * @throws InvalidHTMLVersionException
     * @throws InvalidTypeException
     */
    private function check(&$version)
    {
        $this->checkVersionType($version);

        $version = is_string($version) ? trim($version) : (string) $version;

        if ( empty($version) ) {
            throw new Exception('The HTML Version is empty.');
        }

        if ( ! $this->isSupported($version) ) {
            throw new InvalidHTMLVersionException("The version [$version] is an invalid HTML Version");
        }
    }

    /**
     * @param $version
     *
     * @throws InvalidTypeException
     */
    private function checkVersionType($version)
    {
        if ( ! is_integer($version) and ! is_string($version) ) {
            throw new InvalidTypeException('version', $version, 'string or integer');
        }
    }
}
