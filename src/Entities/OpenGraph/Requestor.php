<?php namespace Arcanedev\Head\Entities\OpenGraph;

class Requestor
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Version
     *
     * @var string
     */
    const VERSION = '1.3';

    /* ------------------------------------------------------------------------------------------------
     |  Main Function
     | ------------------------------------------------------------------------------------------------
     */
    public static function run($url, array $acceptedMimes)
    {
        /*
         * Validate URI string by letting PHP break up the string and put it back together again
         * Excludes username:password and port number URI parts
         */
        $url = self::parseUrl($url);

        if (empty($url)) {
            return $url;
        }

        // test if URL exists
        $ch      = curl_init();

        $options = [
            CURLOPT_URL            => $url,
            CURLOPT_FAILONERROR    => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_FORBID_REUSE   => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_NOBODY         => true,
            CURLOPT_USERAGENT      => 'Open Graph protocol validator ' . self::VERSION . ' (+http://ogp.me/)',
            CURLOPT_RETURNTRANSFER => true,
        ];

        if ( ! empty($acceptedMimes)) {
            $options[CURLOPT_HTTPHEADER] = [
                'Accept: ' . implode(',', $acceptedMimes)
            ];
        }

        curl_setopt_array($ch, $options);

        $response       = curl_exec($ch);
        $statusCode     = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($statusCode != 200 || empty($acceptedMimes)) {
            return '';
        }

        if ($statusCode == 200 && ! empty($acceptedMimes)) {
            $contentType = explode(';', curl_getinfo($ch, CURLINFO_CONTENT_TYPE));

            if (
                empty($contentType) ||
                ! in_array($contentType[0], $acceptedMimes)
            ) {
                return '';
            }
        }

        unset($response);

        return $url;
    }

    /**
     * Parse URL
     *
     * @param  string $url
     *
     * @return string
     */
    private static function parseUrl($url)
    {
        $urlParts   = parse_url($url);

        $url        = '';

        if (
            isset($urlParts['scheme']) and
            in_array($urlParts['scheme'], ['http', 'https'], true)
        ) {
            $url  = $urlParts['scheme'] . "://";
            $url .= $urlParts['host'];
            $url .= isset($urlParts['path']) ? $urlParts['path'] : '';

            if (! isset($urlParts['path']) || empty($urlParts['path'])) {
                $url .= '/';
            }

            if (! empty($urlParts['query'])) {
                $url .= '?' . $urlParts['query'];
            }

            if (! empty($urlParts['fragment'])) {
                $url .= '#' . $urlParts['fragment'];
            }
        }

        return $url;
    }
}
