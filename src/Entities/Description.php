<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Exceptions\InvalidTypeException;

class Description extends AbstractMeta
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var string
     */
    private $description;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
        $this->description = '';
    }

    /* ------------------------------------------------------------------------------------------------
     |   Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Description
     *
     * @return string
     */
    public function get()
    {
        return $this->description;
    }

    /**
     * Set Description
     *
     * @param string $description
     *
     * @throws InvalidTypeException
     *
     * @return Description
     */
    public function set($description)
    {
        $this->check($description);

        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    private function getSEODescription()
    {
        return $this->description;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function render()
    {
        return ! $this->isEmpty()
            ? parent::renderMetaTag('description', $this->getSEODescription())
            : '';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check function
     | ------------------------------------------------------------------------------------------------
     */
    public function isEmpty()
    {
        return empty($this->description);
    }

    /**
     * Check Description
     *
     * @param string $description
     *
     * @throws InvalidTypeException
     */
    private function check(&$description)
    {
        if (! is_string($description)) {
            throw new InvalidTypeException('description', $description, 'string');
        }

        $description = trim($description);
    }
}
