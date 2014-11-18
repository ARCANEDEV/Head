<?php namespace Arcanedev\Head\Entities\OpenGraph\Objects;

use Arcanedev\Head\Entities\OpenGraph;

use DateTime;
use DateTimeZone;

class AbstractObject
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Property prefix
     *
     * @var string
     */
    const PREFIX    ='';

    /**
     * prefix namespace
     *
     * @var string
     */
    const NS        ='';

    /* ------------------------------------------------------------------------------------------------
     |  Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Output the object as HTML <meta> elements
     * @return string HTML meta element string
     */
    public function toHTML()
    {
        return rtrim( OpenGraph::buildHTML( get_object_vars($this), static::PREFIX ), PHP_EOL );
    }

    /**
     * Convert a DateTime object to GMT and format as an ISO 8601 string.
     *
     * @param DateTime $date - date to convert
     *
     * @return string - ISO 8601 formatted datetime string
     */
    public static function datetimeToIso8601(DateTime $date)
    {
        $date->setTimezone(new DateTimeZone('GMT'));

        return $date->format('c');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if URL is valid
     *
     * @uses OpenGraphProtocol::is_valid_url if OpenGraphProtocol::VERIFY_URLS is true
     *
     * @param string $url absolute URL addressable from the public web
     *
     * @return bool - true if URL is non-empty string. if VERIFY_URLS set then URL must also properly respond to a HTTP request.
     */
    public static function isValidUrl( $url )
    {
        if ( is_string($url) && !empty($url) )
        {
            if ( OpenGraph::VERIFY_URLS ) {
                $url = self::isValidUrl($url, ['text/html', 'application/xhtml+xml']);

                if ( ! empty($url) ) {
                    return true;
                }
            }

            return true;
        }

        return false;
    }
}
