<?php namespace Arcanedev\Head\Tests\Support;

use Arcanedev\Head\Support\Collection;
use Arcanedev\Head\Tests\TestCase;

class MetaBuilderTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var MetaBuilderStub */
    private $metaBuilder;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->metaBuilder = new MetaBuilderStub;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->metaBuilder);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @test
     */
    public function testCanRenderMetaTags()
    {
        $prefix     = 'arc';

        $locales    = new Collection([
            ''            => 'fr_FR',
            'alternative' => 'en_EN'
        ]);

        $title       = "Hello World";
        $description = "$title Description";
        $url         = "http://www.arcanedev.net";

        $tags = [
            "<meta name=\"$prefix:title\" content=\"$title\">",
            "<meta name=\"$prefix:description\" content=\"$description\">",
            "<meta name=\"$prefix:url\" content=\"$url\">",
            "<meta name=\"$prefix:locale\" content=\"fr_FR\">",
            "<meta name=\"$prefix:locale:alternative\" content=\"en_EN\">",
        ];

        $this->assertEquals(
            implode(PHP_EOL, $tags),
            MetaBuilderStub::html([
                'title'         => $title,
                'description'   => $description,
                'url'           => $url,
                'locale'        => $locales,
            ])
        );
    }
}
