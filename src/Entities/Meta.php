<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\Entities\MetaInterface;
use Arcanedev\Head\Exceptions\Exception;
use Arcanedev\Head\Exceptions\InvalidTypeException;
use Arcanedev\Markup\Markup;

/**
 * Class Meta
 * @package Arcanedev\Head\Entities
 */
class Meta extends AbstractMeta implements MetaInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $name       = 'name';

    /** @var string */
    protected $content    = '';

    /** @var array */
    protected $attributes = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Meta array
     *
     * @return array
     */
    public function get()
    {
        return $this->toArray();
    }

    /**
     * Set Meta
     *
     * @param string $name
     * @param string $content
     * @param array  $attributes
     *
     * @return Meta
     */
    public function set($name, $content, $attributes = [])
    {
        $this->setName($name)
             ->setContent($content)
             ->setAttributes($attributes);

        return $this;
    }

    /**
     * Set Meta name attribute
     *
     * @param string $name
     *
     * @throws Exception
     * @throws InvalidTypeException
     *
     * @return Meta
     */
    public function setName($name)
    {
        $this->check('name', $name);

        $this->name = $name;

        return $this;
    }

    /**
     * Set Meta content attribute
     *
     * @param string $content
     *
     * @throws Exception
     * @throws InvalidTypeException
     *
     * @return Meta
     */
    public function setContent($content)
    {
        $this->check('content', $content);

        $this->content = $content;

        return $this;
    }

    /**
     * Set other Meta attributes
     *
     * @param array $attributes
     *
     * @return Meta
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get meta array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name'      => $this->name,
            'content'   => $this->content,
            'attributes'=> $this->attributes,
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a Meta
     *
     * @param  string $name
     * @param  string $content
     * @param  array  $attributes
     *
     * @return Meta
     */
    public static function make($name, $content, array $attributes = [])
    {
        return (new self())->set($name, $content, $attributes);
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->isEmpty()) {
            return '';
        }

        return Markup::meta('name', $this->name, $this->content)->render();
    }

    /**
     * Get Viewport meta tag for responsive design
     *
     * @return string
     */
    public function responsive()
    {
        return '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    }

    /**
     * Get IE Edge meta tag
     *
     * @return string
     */
    public function ieEdge()
    {
        return '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->name) || empty($this->content);
    }

    /**
     * @param  string $name
     * @param  string $value
     *
     * @throws Exception
     * @throws InvalidTypeException
     */
    private function check($name, &$value)
    {
        $this->checkIsString($name, $value);

        $value = trim($value);

        if (empty($value)) {
            throw new Exception("The meta $name is empty !");
        }
    }

    /**
     * Check if is string value
     *
     * @param  string $name
     * @param  string $value
     *
     * @throws InvalidTypeException
     */
    private function checkIsString($name, $value)
    {
        if ( ! is_string($value)) {
            throw new InvalidTypeException($name, $value);
        }
    }
}
