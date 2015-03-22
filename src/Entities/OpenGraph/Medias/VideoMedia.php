<?php namespace Arcanedev\Head\Entities\OpenGraph\Medias;

class VideoMedia extends VisualMedia
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    public function getTypeFromUrl()
    {
        $url        = parse_url($this->getURL(), PHP_URL_PATH);
        $pathInfo   = pathinfo($url, PATHINFO_EXTENSION);

        return self::extensionToMediaType($pathInfo);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param string $type
     *
     * @return bool
     */
    protected function checkType($type)
    {
        return $type === 'application/x-shockwave-flash'
            or substr_compare( $type, 'video/', 0, 6 ) === 0;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map a file extension to a registered Internet media type
     * Include Flash as a video type due to its popularity as a wrapper
     *
     * @param string $extension - file extension
     *
     * @return string - Internet media type in the format video/* or Flash
     */
    public static function extensionToMediaType($extension)
    {
        if ( ! self::checkExtension($extension))
            return '';

        switch ($extension) {
            case 'swf':
                return 'application/x-shockwave-flash';

            case 'mp4':
                return 'video/mp4';

            case 'ogv':
                return 'video/ogg';

            case 'webm':
                return 'video/webm';

            default:
                return '';
        }
    }
}
