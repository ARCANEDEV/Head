<?php namespace Arcanedev\Head\Entities\TwitterCard\Cards;

/**
 * Class Player
 * @package Arcanedev\Head\Entities\TwitterCard\Cards
 *
 * @link https://dev.twitter.com/cards/types/player
 * @todo: Complete the class implementation
 */
class Player extends AbstractCard
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $card = 'player';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render the entity
     *
     * @return string
     */
    public function render()
    {
        if ($this->isEmpty()) {
            return '';
        }

        return '';
    }
}
