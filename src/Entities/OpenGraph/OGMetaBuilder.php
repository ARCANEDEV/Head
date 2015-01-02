<?php namespace Arcanedev\Head\Entities\OpenGraph;

use Arcanedev\Head\Support\AbstractMetaBuilder;

class OGMetaBuilder extends AbstractMetaBuilder
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
    protected static $prefix = 'og';

    /**
     * Meta attribute name. Use 'property' if you prefer RDF or 'name' if you prefer HTML validation
     *
     * @var string
     */
    protected static $metaName = 'property';
}
