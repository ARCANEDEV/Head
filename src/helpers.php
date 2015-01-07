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
