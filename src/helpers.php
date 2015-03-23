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
            ? (($protocol and $protocol != "off") ? "https" : "http")
            : 'http';

        return rtrim($protocol . "://" . $host, '/') . '/' . $path;
    }
}