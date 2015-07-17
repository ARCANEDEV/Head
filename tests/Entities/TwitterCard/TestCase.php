<?php namespace Arcanedev\Head\Tests\Entities\TwitterCard;

use Arcanedev\Head\Entities\TwitterCard\Cards\AbstractCard;
use Arcanedev\Head\Tests\Entities\TestCase as EntitiesTestCase;

/**
 * Class TestCase
 * @package Arcanedev\Head\Tests\Entities\TwitterCard
 */
abstract class TestCase extends EntitiesTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var AbstractCard */
    protected $card;

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Generate twitter card tags
     *
     * @param  array $tags
     *
     * @return string
     */
    protected function generateTags(array $tags)
    {
        $result = [];

        foreach ($tags as $name => $content) {
            $result[] = "<meta name=\"twitter:$name\" content=\"$content\">";
        }

        return implode(PHP_EOL, $result);
    }
}
