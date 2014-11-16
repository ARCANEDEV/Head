<?php namespace Arcanedev\Head\Entities;

class Description extends AbstractMeta
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var string
     */
    private $description = '';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
    }

    /* ------------------------------------------------------------------------------------------------
     |   Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    public function get()
    {
        return $this->description;
    }

    public function set($description)
    {
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
        return parent::renderMetaTag('description', $this->getSEODescription());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check function
     | ------------------------------------------------------------------------------------------------
     */
    public function isEmpty()
    {
        return empty($this->description);
    }
}
