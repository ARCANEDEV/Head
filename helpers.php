<?php

/**
 * Open Graph protocol type labels are passed through gettext message interpreters for the current context.
 * Fake the interpreter function alias if not defined
 */
if ( ! function_exists('_')) {
    /**
     * @param  string $text
     * @param  string $domain
     *
     * @return string
     */
    function _($text, $domain = '') {
        return $text;
    }
}

if ( ! function_exists('base_url')) {
    /**
     * Get base url
     *
     * @param  string $path
     *
     * @return string
     */
    function base_url($path = '') {

        $host = filter_input(INPUT_SERVER, 'HTTP_HOST');

        if ( ! isset($host)) {
            return $path;
        }

        $protocol = filter_input(INPUT_SERVER, 'HTTPS');
        $protocol = isset($protocol)
            ? (($protocol and $protocol != 'off') ? 'https' : 'http')
            : 'http';

        return rtrim($protocol . '://' . $host, '/') . '/' . $path;
    }
}

if ( ! function_exists('get_default_charsets')) {
    /**
     * Get default charsets
     *
     * @return string[]
     */
    function get_default_charsets() {
        return require __DIR__ . '/data/charsets.php';
    }
}

if ( ! function_exists('get_supported_locales')) {
    /**
     * Get supported locales
     *
     * @return array
     */
    function get_supported_locales() {
        return require __DIR__ . '/data/locales.php';
    }
}

if ( ! function_exists('get_og_types')) {
    /**
     * Get OpenGraph types
     *
     * @return array
     */
    function get_og_types() {
        return require __DIR__ . '/data/open-graph/types.php';
    }
}
