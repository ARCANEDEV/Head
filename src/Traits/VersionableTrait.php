<?php namespace Arcanedev\Head\Traits;

use Arcanedev\Head\Support\HTMLVersion;

use Arcanedev\Head\Exceptions\InvalidHTMLVersionException;
use Arcanedev\Head\Exceptions\InvalidTypeException;

trait VersionableTrait
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var  HTMLVersion */
    protected $version;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version->get();
    }

    /**
     * @param string $version
     *
     * @throws InvalidTypeException
     * @throws InvalidHTMLVersionException
     *
     * @return mixed
     */
    public function setVersion($version)
    {
        $this->version->set($version);

        return $this;
    }

    /**
     * Get HTML Version
     *
     *
     * @param string|HTMLVersion $version
     *
     * @throws InvalidTypeException
     * @throws InvalidHTMLVersionException
     *
     * @return mixed|string
     */
    public function version($version = '')
    {
        return empty($version)
            ? $this->getVersion()
            : $this->setVersion($version);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function initVersion()
    {
        $this->version = new HTMLVersion;
    }
}
