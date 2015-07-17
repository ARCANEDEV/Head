<?php namespace Arcanedev\Head\Entities\TwitterCard;

use Arcanedev\Head\Contracts\Renderable;
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
    protected $card        = 'summary';

    protected $site        = ''; // @

    protected $creator     = ''; // @

    protected $title       = '';

    protected $description = '';

    protected $image       = '';

    protected $url         = '';

    private static $types  = [
        'gallery'             => 'Gallery',
        'summary'             => 'Summary',
        'summary_large_image' => 'Summary Large Image',
        'photo'               => 'Photo',
        'player'              => 'Player',
        'product'             => 'Product',
    ];

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
