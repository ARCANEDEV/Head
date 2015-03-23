<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\Entities\DescriptionInterface;
use Arcanedev\Head\Exceptions\InvalidTypeException;

class Description extends AbstractMeta implements DescriptionInterface
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
     * Get SEO Description
     *
     * @return string
     */
    private function getSEODescription()
    {
        // TODO: Get Optimized Description
        return $this->description;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render Description tag
     *
     * @return string
     */
    public function render()
    {
        return ! $this->isEmpty()
            ? $this->renderMetaTag('description', $this->getSEODescription())
            : '';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if description is empty
     *
     * @return bool
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
        if ( ! is_string($description)) {
            throw new InvalidTypeException('description', $description, 'string');
        }

        $description = trim($description);
    }
}
