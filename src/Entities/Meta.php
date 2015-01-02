<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\Entities\MetaInterface;
use Arcanedev\Head\Exceptions\Exception;
use Arcanedev\Head\Exceptions\InvalidTypeException;

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

    /**
     * Make a Meta
     *
     * @param string $name
     * @param string $content
     * @param array  $attributes
     *
     * @return Meta
     */
    public static function make($name, $content, $attributes = [])
    {
        return (new self())->set($name, $content, $attributes);
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
     * @return string
     */
    public function render()
    {
        return ! $this->isEmpty()
            ? '<meta name="' . $this->name . '" content="' . $this->content . '">'
            : '';
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
        return empty($this->name) or empty($this->content);
    }

    /**
     * @param string $name
     * @param string $value
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
     * @param string $name
     * @param string $value
     *
     * @throws InvalidTypeException
     */
    private function checkIsString($name, $value)
    {
        if (! is_string($value)) {
            throw new InvalidTypeException($name, $value);
        }
    }
}
