<?php namespace Arcanedev\Head\Entities\OpenGraph\Medias;

use Arcanedev\Head\Contracts\Arrayable;
use Arcanedev\Head\Entities\OpenGraph\OpenGraph;

/**
 * Class AbstractMedia
 * @package Arcanedev\Head\Entities\OpenGraph\Medias
 */
abstract class AbstractMedia implements Arrayable
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * HTTP scheme URL
     *
     * @var string
     */
    protected $url;

    /**
     * HTTPS scheme URL
     *
     * @var string
     */
    protected $secureUrl;

    /**
     * Internet media type of the linked URLs
     *
     * @var string
     */
    protected $type;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get URL
     *
     * @return string
     */
    public function getURL()
    {
        return $this->isEmpty() ? '' : $this->url;
    }

    /**
     * Set the media URL
     *
     * @param  string $url - resource location
     *
     * @return self
     */
    public function setURL($url)
    {
        if ($this->checkURL($url)) {
            $url = trim($url);

            $url = $this->verifyUrl($url);

            if ( ! empty($url) ) {
                $this->url = $url;
            }
        }

        return $this;
    }

    /**
     * @return string - Get secure URL string or null if not set
     */
    public function getSecureURL()
    {
        return $this->secureUrl;
    }

    /**
     * Set the secure URL for display in a HTTPS page
     *
     * @param string $url - resource location
     *
     * @return self
     */
    public function setSecureURL($url)
    {
        if ($this->checkURL($url)) {
            $url = trim($url);

            $url = $this->verifySecureURL($url);

            if ( ! empty($url)) {
                $this->secureUrl = $url;
            }
        }

        return $this;
    }

    /**
     * Get the Internet media type of the referenced resource
     *
     * @return string - Internet media type or null if none set
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the Internet media type. Allow only audio types + Flash wrapper.
     *
     * @param string $type Internet media type
     *
     * @return self
     */
    public function setType( $type )
    {
        if ($this->checkType($type)) {
            $this->type = $type;
        }

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function isEmpty()
    {
        return ! isset($this->url) || empty($this->url);
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    private function checkURL($url)
    {
        return is_string($url) && ! empty($url);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    abstract protected function checkType($type);

    /**
     * @param string $extension
     *
     * @return bool
     */
    protected static function checkExtension($extension)
    {
        return is_string($extension) && ! empty($extension);
    }

    /**
     * @param $url
     *
     * @return string
     */
    private function verifyUrl($url)
    {
        if ( ! OpenGraph::VERIFY_URLS) {
            return $url;
        }

        return $this->validateURL($url);
    }

    /**
     * @param string $secureURL
     *
     * @return string
     */
    private function verifySecureURL($secureURL)
    {
        if ( ! OpenGraph::VERIFY_URLS) {
            return $secureURL;
        }

        return $this->isSecureURL($secureURL)
            ? $this->validateURL($secureURL)
            : '';
    }

    /**
     * @param string $secureURL
     *
     * @return bool
     */
    private function isSecureURL($secureURL)
    {
        return parse_url($secureURL, PHP_URL_SCHEME) === 'https';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Remove the URL property.
     * Sets up the maximum compatibility between image and image:url indexers
     */
    public function removeURL()
    {
        if ( ! empty($this->url)) {
            $this->url = '';
        }
    }

    /**
     * Treat a string reference just like the base property
     */
    public function toString()
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function validateURL($url)
    {
        return OpenGraph::isValidUrl($url, [
            'text/html', 'application/xhtml+xml'
        ]);
    }
}
