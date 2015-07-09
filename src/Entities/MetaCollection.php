<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Exceptions\Exception;
use Arcanedev\Head\Support\Collection;

/**
 * Class MetaCollection
 * @package Arcanedev\Head\Entities
 */
class MetaCollection extends Collection
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make Meta Collection
     *
     * @param  array $items
     *
     * @return MetaCollection
     */
    public static function make(array $items)
    {
        return (new self)->addMany($items);
    }

    /**
     * Add many metas
     *
     * @param  array $metas
     *
     * @return MetaCollection
     */
    public function addMany(array $metas)
    {
        foreach ($metas as $meta) {
            $this->addMetaOne($meta);
        }

        return $this;
    }

    /**
     * @param array $meta
     *
     * @throws Exception
     *
     * @return self
     */
    public function addMetaOne(array $meta)
    {
        $name       = $this->getAttribute('name', $meta);
        $content    = $this->getAttribute('content', $meta);
        $attributes = array_key_exists('attributes', $meta)
            ? $meta['attributes']
            : [];

        $this->addMeta($name, $content, $attributes);

        return $this;
    }

    /**
     * Add a meta to collection
     *
     * @param  string $name
     * @param  string $content
     * @param  array  $attributes
     *
     * @return MetaCollection
     */
    public function addMeta($name, $content, array $attributes = [])
    {
        $meta = Meta::make($name, $content, $attributes);

        return $this->setMeta($meta);
    }

    /**
     * @param Meta $meta
     *
     * @return MetaCollection
     */
    public function setMeta(Meta $meta)
    {
        $this->push($meta);

        return $this;
    }

    /**
     * Render all metas tag
     *
     * @return string
     */
    public function render()
    {
        $metas = $this->each(function(Meta $meta) {
            return $meta->render();
        });

        return implode(PHP_EOL, $metas->toArray());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get attribute
     *
     * @param  string $key
     * @param  array  $meta
     *
     * @throws Exception
     *
     * @return string
     */
    private function getAttribute($key, array $meta)
    {
        if ( ! isset($meta[$key])) {
            throw new Exception("The meta [{$key}] attribute not found !");
        }

        return $meta[$key];
    }
}
