<?php namespace Arcanedev\Head\Entities\OpenGraph\Objects;

use Arcanedev\Head\Entities\OpenGraph\OGMetaBuilder;
use Arcanedev\Head\Entities\OpenGraph\OpenGraph;
use DateTime;
use DateTimeZone;

/**
 * Class AbstractObject
 * @package Arcanedev\Head\Entities\OpenGraph\Objects
 */
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
        return rtrim(OGMetaBuilder::html(get_object_vars($this), static::PREFIX), PHP_EOL);
    }

    /**
     * Convert a DateTime object to GMT and format as an ISO 8601 string.
     *
     * @param  DateTime $date
     *
     * @return string
     */
    public static function datetimeToIso8601(DateTime $date)
    {
        return $date->setTimezone(new DateTimeZone('GMT'))
                    ->format('c');
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
    public static function isValidUrl($url, array $types = ['text/html', 'application/xhtml+xml'])
    {
        if (is_string($url) && ! empty($url)) {
            if (OpenGraph::VERIFY_URLS) {
                if ( ! empty(self::isValidUrl($url, $types))) {
                    return true;
                }
            }

            return true;
        }

        return false;
    }
}
