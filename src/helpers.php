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
        if ( ! isset($_SERVER['HTTP_HOST'])) {
            return $path;
        }

        $protocol = isset($_SERVER['HTTPS'])
            ? (($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http")
            : 'http';

        return rtrim($protocol . "://" . $_SERVER['HTTP_HOST'], '/') . '/' . $path;
    }
}