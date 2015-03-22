<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\Entities\CharsetInterface;
use Arcanedev\Head\Contracts\Versionable;
use Arcanedev\Head\Exceptions\InvalidTypeException;
use Arcanedev\Head\Traits\VersionableTrait;

class Charset extends AbstractMeta implements CharsetInterface, Versionable
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const DEFAULT_CHARSET       = 'UTF-8';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var string
     */
    protected $charset          = "";

    /**
     * @var array
     */
    protected static $supportedCharset = [];

    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use VersionableTrait;

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
        return $this->isEmpty()
            ? $this->getDefault()
            : $this->charset;
    }

    /**
     * Set Charset
     *
     * @param string $charset
     *
     * @return Charset
     */
    public function set($charset)
    {
        return $this->setCharset($charset);
    }

    /**
     * Set Charset
     *
     * @param string $charset
     *
     * @throws InvalidTypeException
     *
     * @return Charset
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
     * @param string $charset
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
        if (! is_string($charset)) {
            throw new InvalidTypeException('charset', $charset);
        }

        $charset = $this->isSupported($charset)
            ? $this->getFromSupported($charset, true)
            : $this->getDefault();
    }

    /**
     * Check if charset is supported
     *
     * @param string $charset
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

        $result = array_intersect(self::getAllSupportedCharsets(), [
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
     * @return array
     */
    private function getDefaultCharsets()
    {
        return [
            'pass', 'auto', 'wchar', 'byte2be', 'byte2le', 'byte4be', 'byte4le', 'BASE64', 'UUENCODE', 'HTML-ENTITIES',
            'Quoted-Printable', '7bit', '8bit', 'UCS-4', 'UCS-4BE', 'UCS-4LE', 'UCS-2', 'UCS-2BE', 'UCS-2LE', 'UTF-32',
            'UTF-32BE', 'UTF-32LE', 'UTF-16', 'UTF-16BE', 'UTF-16LE', 'UTF-8', 'UTF-7', 'UTF7-IMAP', 'ASCII', 'EUC-JP',
            'SJIS', 'eucJP-win', 'EUC-JP-2004', 'SJIS-win', 'SJIS-Mobile#DOCOMO', 'SJIS-Mobile#KDDI', 'SJIS-Mobile#SOFTBANK',
            'SJIS-mac', 'SJIS-2004', 'UTF-8-Mobile#DOCOMO', 'UTF-8-Mobile#KDDI-A', 'UTF-8-Mobile#KDDI-B', 'UTF-8-Mobile#SOFTBANK',
            'CP932', 'CP51932', 'JIS', 'ISO-2022-JP', 'ISO-2022-JP-MS', 'GB18030', 'Windows-1252', 'Windows-1254',
            'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5', 'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8',
            'ISO-8859-9', 'ISO-8859-10', 'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16', 'EUC-CN', 'CP936',
            'HZ', 'EUC-TW', 'BIG-5', 'CP950', 'EUC-KR', 'UHC', 'ISO-2022-KR', 'Windows-1251', 'CP866', 'KOI8-R', 'KOI8-U',
            'ArmSCII-8', 'CP850', 'JIS-ms', 'ISO-2022-JP-2004', 'ISO-2022-JP-MOBILE#KDDI', 'CP50220', 'CP50220raw', 'CP50221',
            'CP50222',
        ];
    }
}
