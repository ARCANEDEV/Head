<?php namespace Arcanedev\Head\Utilities;

use Arcanedev\Head\Exceptions\FileNotFoundException;
use Arcanedev\Head\Exceptions\InvalidTypeException;
use Arcanedev\Head\Support\Collection;

/**
 * Class Config
 * @package Arcanedev\Head\Utilities
 */
class Config extends Collection
{
    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct($items = [])
    {
        parent::__construct(array_merge(self::getDefaults(), $items));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get default Config
     *
     * @return array
     */
    private static function getDefaults()
    {
        return include __DIR__ . '/../../config/config.php';
    }

    public function path($path)
    {
        $config = [];

        if ( ! empty($path)) {
            $this->checkPath($path);

            $config = include $path;

            $this->checkFile($config);
        }

        return new self($config);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check config path
     *
     * @param  string $path
     *
     * @throws FileNotFoundException
     */
    private function checkPath($path)
    {
        if ( ! file_exists($path)) {
            throw new FileNotFoundException('Configuration file not found [' . $path . '] !');
        }
    }

    /**
     * Check config file
     *
     * @param  array $config
     *
     * @throws InvalidTypeException
     */
    private function checkFile($config)
    {
        if ( ! is_array($config)) {
            throw new InvalidTypeException('Configuration file', $config, 'array');
        }
    }
}
