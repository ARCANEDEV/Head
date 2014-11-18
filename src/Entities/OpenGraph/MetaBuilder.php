<?php namespace Arcanedev\Head\Entities\OpenGraph;

use Arcanedev\Head\Contracts\ArrayableInterface;

class MetaBuilder
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Property prefix
     *
     * @var string
     */
    const PREFIX = 'og';

    /**
     * Meta attribute name. Use 'property' if you prefer RDF or 'name' if you prefer HTML validation
     *
     * @var string
     */
    const META_ATTR = 'property';

    /* ------------------------------------------------------------------------------------------------
     |  Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Build Open Graph protocol HTML markup based on an array
     *
     * @param array  $attributes     - associative array of OGP properties and values
     * @param string $prefix - optional prefix to prepend to all properties
     *
     * @return string
     */
    public static function html(array $attributes, $prefix = self::PREFIX)
    {
        $output = [];

        if ( ! empty($attributes) ) {
            self::generateAttributesMetas($output, $attributes, $prefix);
        }

        return self::implode($output, PHP_EOL);
    }

    /**
     * @param array  $output
     * @param array  $attributes
     * @param string $prefix
     */
    protected static function generateAttributesMetas(&$output, array $attributes, $prefix)
    {
        foreach ($attributes as $property => $content) {
            self::generatePropertyMeta($output, $prefix, $content, $property);
        }
    }

    /**
     * @param $output
     * @param $prefix
     * @param $content
     * @param $property
     */
    protected static function generatePropertyMeta(&$output, $prefix, $content, $property)
    {
        if ( is_object($content) or is_array($content) ) {
            if ( is_object($content) and $content instanceof ArrayableInterface ) {
                $content = $content->toArray();
            }

            $prefix .= ((is_string($property) and ! empty($property)) ? ':' . $property : '');

            $output[] = self::html($content, $prefix);
        }
        elseif ( !empty($content) ) {
            $output[] = self::meta($prefix, $property, $content);
        }
    }

    /**
     * @param string $prefix
     * @param string $property
     * @param string $content
     *
     * @return string
     */
    private static function meta($prefix, $property, $content)
    {
        return '<meta ' . self::getMetaProperty($prefix, $property) . ' ' . self::getMetaContent($content) .'>';
    }

    private static function getMetaProperty($prefix, $property)
    {
        $output = [
            self::META_ATTR . '="' . $prefix,
            (is_string($property) and ! empty($property)) ? ':' . htmlspecialchars($property) : '',
            '"',
        ];

        return self::implode($output);
    }

    private static function getMetaContent($content)
    {
        return 'content="' . htmlspecialchars($content) . '"';
    }

    private static function implode($output, $glue = '')
    {
        return implode($glue, array_filter($output));
    }
}
