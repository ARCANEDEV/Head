<?php namespace Arcanedev\Head\Traits;

/**
 * Trait EnablerTrait
 * @package Arcanedev\Head\Traits
 */
trait EnablerTrait
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var bool
     */
    protected $enabled = false;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get enable status
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param  bool $enabled
     *
     * @return self
     */
    protected function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Enable the google analytics
     *
     * @return self
     */
    public function enable()
    {
        return $this->setEnabled(true);
    }

    /**
     * Disable the google analytics
     *
     * @return self
     */
    public function disable()
    {
        return $this->setEnabled(false);
    }
}
