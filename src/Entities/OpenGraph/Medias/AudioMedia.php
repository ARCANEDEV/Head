<?php namespace Arcanedev\Head\Entities\OpenGraph\Medias;

/**
 * Class AudioMedia
 * @package Arcanedev\Head\Entities\OpenGraph\Medias
 */
class AudioMedia extends AbstractMedia
{
    /* ------------------------------------------------------------------------------------------------
     |  Check Function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param string $type
     *
     * @return bool
     */
    protected function checkType($type)
    {
        return $type === 'application/x-shockwave-flash' ||
               substr_compare($type, 'audio/', 0, 6) === 0;
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
     * @return string - Internet media type in the format audio/* or Flash
     */
    public static function extensionToMediaType($extension)
    {
        if ( ! self::checkExtension($extension)) {
            return '';
        }

        switch ($extension) {
            case 'swf':
                return 'application/x-shockwave-flash';

            case 'mp3':
                return 'audio/mpeg';

            case 'm4a':
                return 'audio/mp4';

            case 'ogg':
            case 'oga':
                return 'audio/ogg';

            default:
                return '';
        }
    }
}
