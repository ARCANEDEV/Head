<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Exceptions\Exception;
use Arcanedev\Head\Support\Collection;

class MetaCollection extends Collection
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    protected $items = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructors
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    /**
     * Make Meta Collection
     *
     * @param array $items
     *
     * @return MetaCollection
     */
    public static function make(array $items)
    {
        return (new self)->addMany($items);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add many metas
     *
     * @param array $metas
     *
     * @return MetaCollection
     */
    public function addMany(array $metas)
    {
        foreach ($metas as $meta) {
            $this->addMetaArray($meta);
        }

        return $this;
    }

    /**
     * @param array $meta
     *
     * @throws Exception
     *
     * @return $this
     */
    public function addMetaArray(array $meta)
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
     * @param string $name
     * @param string $content
     * @param array  $attributes
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
     * @return String
     */
    public function render()
    {
        $metas = $this->each(function($meta) {
            /** @var Meta $meta */
            return $meta->render();
        });

        /** @var Collection $metas */
        return implode(PHP_EOL, $metas);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param string $key
     * @param array  $meta
     *
     * @throws Exception
     *
     * @return string
     */
    private function getAttribute($key, array $meta)
    {
        if (! array_key_exists($key, $meta)) {
            throw new Exception("The meta [$key] attribute not found !");
        }

        $value = $meta[$key];

        return $value;
    }
}
