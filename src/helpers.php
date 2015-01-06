<?php

use Arcanedev\Head\Exceptions\FileNotFoundException;
use Arcanedev\Markup\Exceptions\InvalidTypeException;

/**
 * Open Graph protocol type labels are passed through gettext message interpreters for the current context.
 * Fake the interpreter function alias if not defined
 */
if (! function_exists('_') ) {
    function _($text, $domain = '') {
        return $text;
    }
}

if (! function_exists('get_config')) {
    /**
     * Get Configuration from a file
     *
     * @param string $path
     *
     * @throws FileNotFoundException
     * @throws InvalidTypeException
     *
     * @return array
     */
    function get_config($path = '') {
        $config = [];

        if (! empty($path)) {
            if (! file_exists($path)) {
                $msg = "Configuration file not found [$path] !";

                throw new FileNotFoundException($msg);
            }

            $config = include_once $path;

            if (! is_array($config)) {
                $msg = "Configuration file must return an array, " . gettype($config) . " is given !";

                throw new InvalidTypeException($msg);
            }
        }

        return array_merge(get_default_config(), $config);
    }
}

if (! function_exists('get_default_config')) {
    /**
     * Get Default Configuration
     *
     * @return array
     */
    function get_default_config()
    {
        return include_once __DIR__ . '/config/config.php';
    }
}
