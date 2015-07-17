<?php namespace Arcanedev\Head\Entities\TwitterCard\Cards;

use Arcanedev\Head\Contracts\Renderable;

/**
 * Class AbstractCard
 * @package Arcanedev\Head\Entities\TwitterCard\Cards
 */
abstract class AbstractCard implements Renderable
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $card;

    /** @var string */
    protected $site        = '';

    /** @var string */
    protected $title       = '';

    /** @var string */
    protected $description = '';

    protected $baseRequired = [
        'title', 'description',
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {

    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */


    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->title);
    }
}
