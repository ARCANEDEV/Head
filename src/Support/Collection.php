<?php namespace Arcanedev\Head\Support;

use Closure;
use Countable;
use ArrayAccess;

class Collection implements Countable, ArrayAccess
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var array */
    protected $items = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param array $items
     */
    function __construct(array $items = [])
    {
        $items = ! is_null($items)
            ? $this->getArrayableItems($items)
            : [];

        $this->items = (array) $items;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get all of the items in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * @param mixed      $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get($key, $default= null)
    {
        if ( $this->offsetExists($key) ) {
            return $this->offsetGet($key);
        }

        return $this->value($default);
    }

    /**
     * Set an item in the collection by key.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return Collection
     */
    public function set($key, $value)
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * Put an item in the collection by key.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return Collection
     */
    public function put($key, $value)
    {
        return $this->set($key, $value);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Remove an item from the collection by key.
     *
     * @param  mixed  $key
     * @return void
     */
    public function forget($key)
    {
        $this->offsetUnset($key);
    }

    /**
     * Execute a callback over each item.
     *
     * @param  Closure  $callback
     *
     * @return Collection
     */
    public function each(Closure $callback)
    {
        array_map($callback, $this->items);

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  ArrayAccess Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     *
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if ( is_null($key) ) {
            $this->items[]      = $value;
        }
        else {
            $this->items[$key]  = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Countable Function
     | ------------------------------------------------------------------------------------------------
     */
    public function count()
    {
        return count($this->items);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Results array of items from Collection.
     *
     * @param  Collection|array  $items
     *
     * @return array
     */
    protected function getArrayableItems($items)
    {
        if ( $items instanceof Collection ) {
            $items = $items->all();
        }

        return $items;
    }

    /**
     * Return the default value of the given value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    private function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}
