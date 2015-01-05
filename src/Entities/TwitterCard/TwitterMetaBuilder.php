<?php namespace Arcanedev\Head\Entities\TwitterCard;

use Arcanedev\Head\Support\AbstractMetaBuilder;

class TwitterMetaBuilder extends AbstractMetaBuilder
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Property prefix
     *
     * @var string
     */
    protected static $prefix = 'twitter';

    /**
     * Meta attribute name. Use 'property' if you prefer RDF or 'name' if you prefer HTML validation
     *
     * @var string
     */
    protected static $metaName = 'name';
}
