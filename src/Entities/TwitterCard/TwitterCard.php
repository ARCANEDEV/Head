<?php namespace Arcanedev\Head\Entities\TwitterCard;

/**
 * Class TwitterCard
 * @package Arcanedev\Head\Entities\TwitterCard
 *
 * @todo: complete the implementation
 */
class TwitterCard
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
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getter & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set enabled
     *
     * @param  bool $enabled
     *
     * @return self
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Enable twitter card
     *
     * @return self
     */
    public function enable()
    {
        return $this->setEnabled(true);
    }

    /**
     * Disable twitter card
     *
     * @return self
     */
    public function disable()
    {
        return $this->setEnabled(false);
    }
}
