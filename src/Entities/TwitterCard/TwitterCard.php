<?php namespace Arcanedev\Head\Entities\TwitterCard;

use Arcanedev\Head\Contracts\Renderable;
use Arcanedev\Head\Entities\TwitterCard\Cards\AbstractCard;
use Arcanedev\Head\Traits\EnablerTrait;

/**
 * Class TwitterCard
 * @package Arcanedev\Head\Entities\TwitterCard
 *
 * @todo: complete the implementation
 */
class TwitterCard implements Renderable
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use EnablerTrait;

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var string
     */
    protected $type        = 'summary';

    /**
     * @var array
     */
    private static $types  = [
        'app'                 => 'App',
        'gallery'             => 'Gallery',
        'photo'               => 'Photo',
        'player'              => 'Player',
        'product'             => 'Product',
        'summary'             => 'Summary',
        'summary_large_image' => 'Summary Large Image',
    ];

    /** @var AbstractCard */
    protected $card;

    /**
     * @var string
     */
    protected $site        = ''; // @

    /**
     * @var string
     */
    protected $creator     = ''; // @

    /**
     * @var string
     */
    protected $title       = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $image       = '';

    /**
     * @var string
     */
    protected $url         = '';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
        // TODO: Implement __construct() method.
    }


    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function render()
    {
        if ($this->isEnabled()) {
            return '';
        }

        return '';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */

}
