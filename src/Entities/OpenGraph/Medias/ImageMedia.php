<?php namespace Arcanedev\Head\Entities\OpenGraph\Medias;

class ImageMedia extends VisualMedia
{
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
        return substr_compare($type, 'image/', 0, 6) === 0;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map a file extension to a registered Internet media type
     *
     * @param string - $extension file extension
     *
     * @return string|null - Internet media type in the format image/*
     */
    public static function extensionToMediaType($extension)
    {
        if ( ! self::checkExtension($extension) )
            return null;

        switch($extension) {
            case "jpeg":
            case "jpg":
                return 'image/jpeg';

            case "png":
                return 'image/png';

            case "gif":
                return 'image/gif';

            case "svg":
                return 'image/svg+sml';

            case "ico":
                return 'image/vnd.microsoft.icon';

            default:
                return null;
        }
    }
}
