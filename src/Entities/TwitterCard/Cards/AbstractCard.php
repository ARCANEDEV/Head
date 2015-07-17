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
    protected $card        = 'app';

    protected $site        = '';

    protected $title       = '';

    protected $description = '';

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
}
