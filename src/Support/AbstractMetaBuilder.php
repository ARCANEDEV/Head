<?php namespace Arcanedev\Head\Support;

use Arcanedev\Head\Contracts\ArrayableInterface;

abstract class AbstractMetaBuilder
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
    protected static $prefix = '';

    /**
     * Meta attribute name. Use 'property' if you prefer RDF or 'name' if you prefer HTML validation
     *
     * @var string
     */
    protected static $metaName = 'name';

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
    public static function html(array $attributes, $prefix = '')
    {
        $output = [];

        if (empty($prefix)) {
            $prefix = static::$prefix;
        }

        if (! empty($attributes)) {
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
     * Generate Property Meta
     *
     * @param array               $output
     * @param string              $prefix
     * @param object|array|string $content
     * @param string              $property
     */
    protected static function generatePropertyMeta(&$output, $prefix, $content, $property)
    {
        if (is_object($content) or is_array($content)) {
            if (is_object($content) and $content instanceof ArrayableInterface) {
                $content = $content->toArray();
            }

            if ((is_string($property) and ! empty($property))) {
                $prefix .= ':' . $property;
            }

            $output[] = self::html($content, $prefix);
        }
        elseif (! empty($content)) {
            $output[] = self::meta($prefix, $property, $content);
        }
    }

    /**
     * Render Meta Tag
     *
     * @param string $prefix
     * @param string $property
     * @param string $content
     *
     * @return string
     */
    private static function meta($prefix, $property, $content)
    {
        $property = self::getMetaProperty($prefix, $property);
        $content  = self::getMetaContent($content);

        return "<meta $property $content>";
    }

    /**
     * Get Meta Property
     *
     * @param string $prefix
     * @param string $property
     *
     * @return string
     */
    private static function getMetaProperty($prefix, $property)
    {
        $property = (is_string($property) and ! empty($property))
            ? ':' . htmlspecialchars($property)
            : '';

        return self::implode([
            static::$metaName . '="' . $prefix, $property, '"',
        ]);
    }

    /**
     * Get Meta Content
     *
     * @param $content
     *
     * @return string
     */
    private static function getMetaContent($content)
    {
        return 'content="' . htmlspecialchars($content) . '"';
    }

    /**
     * Implode output array
     *
     * @param array  $output
     * @param string $glue
     *
     * @return string
     */
    private static function implode(array $output, $glue = '')
    {
        return implode($glue, array_filter($output));
    }
}
