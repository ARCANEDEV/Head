<?php namespace Arcanedev\Head\Tests;

use Arcanedev\Head\Entities\Charset;
use Arcanedev\Head\Entities\Description;
use Arcanedev\Head\Entities\Keywords;
use Arcanedev\Head\Entities\Meta;
use Arcanedev\Head\Entities\OpenGraph\OpenGraph;
use Arcanedev\Head\Entities\Title;
use Arcanedev\Head\Entities\TwitterCard\TwitterCard;
use Arcanedev\Head\Head;

/**
 * Class HeadTest
 * @package Arcanedev\Head\Tests
 */
class HeadTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Head */
    protected $head;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function setUp()
    {
        parent::setUp();

        $this->head = new Head;
    }

    protected function tearDown()
    {
        parent::tearDown();

        unset($this->head);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Head::class, $this->head);
        $this->assertEquals('UTF-8', $this->head->charset()->get());
    }

    /** @test */
    public function it_can_get_default_config()
    {
        $config     = $this->head->getConfig();

        $this->assertConfig($config);
        $this->assertEquals('UTF-8', $config['charset']);
    }

    /** @test */
    public function it_can_set_and_get_config_from_array()
    {
        $this->head->setConfig([
            'charset' => 'ISO-8859-1',
        ]);

        $config = $this->head->getConfig();

        $this->assertConfig($config);
        $this->assertEquals('ISO-8859-1', $config->get('charset'));
        $this->assertEquals('ISO-8859-1', $config['charset']);
    }

    /** @test */
    public function it_can_set_and_get_config_from_file()
    {
        $this->head->configPath(__DIR__ . '/data/config-valid.php');

        $config = $this->head->getConfig();

        $this->assertConfig($config);
        $this->assertEquals('ISO-8859-1', $config->get('charset'));
        $this->assertEquals('ISO-8859-1', $config['charset']);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\FileNotFoundException
     */
    public function it_must_throw_file_not_found_exception_on_config_path()
    {
        $this->head->configPath(__DIR__ . '/data/config-not-found.php');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function it_must_throw_invalid_type_exception_on_config_path()
    {
        $this->head->configPath(__DIR__ . '/data/config-invalid.php');
    }

    /** @test */
    public function it_can_set_and_get_charset()
    {
        $this->assertEquals('UTF-8', $this->head->charset()->get());
        $this->assertEquals(
            '<meta charset="UTF-8">',
            $this->head->charset()->render()
        );

        $this->head->setCharset('ISO-8859-1');

        $this->assertEquals('ISO-8859-1', $this->head->charset()->get());
        $this->assertEquals(
            '<meta charset="ISO-8859-1">',
            $this->head->charset()->render()
        );

        $this->head->setCharset(Charset::make('UTF-8'));

        $this->assertEquals('UTF-8', $this->head->charset()->get());
        $this->assertEquals(
            '<meta charset="UTF-8">',
            $this->head->charset()->render()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function it_must_throw_invalid_type_exception_on_charset()
    {
        $this->head->setCharset(true);
    }

    /** @test */
    public function it_can_set_and_get_title()
    {
        $title = 'Hello Title';
        $this->head->setTitle($title);

        $this->assertEquals($title, $this->head->getTitle());
        $this->assertEquals(
            '<title>Hello Title</title>',
            $this->head->title()->render()
        );
    }

    /** @test */
    public function it_can_set_and_get_site_name()
    {
        $siteName = 'Company name';

        $this->head->setSiteName($siteName);

        $this->assertEquals($siteName, $this->head->getSiteName());
    }

    /** @test */
    public function it_can_set_and_get_by_title_class()
    {
        $title = new Title;
        $title->set('Hello Title')
              ->setSiteName('Company Name')
              ->separator('||');

        $this->head->setTitle($title);

        $this->assertEquals('Hello Title', $this->head->getTitle());
        $this->assertEquals(
            '<title>Hello Title || Company Name</title>',
            $this->head->title()->render()
        );
    }

    /** @test */
    public function it_can_show_and_hide_site_name()
    {
        $title    = 'Hello Title';
        $siteName = 'Company Name';
        $this->head->setTitle($title)->setSiteName($siteName);

        $this->assertEquals(
            "<title>$title - $siteName</title>",
            $this->head->title()->render()
        );

        $this->head->hideSiteName();

        $this->assertEquals(
            "<title>$title</title>",
            $this->head->title()->render()
        );

        $this->head->showSiteName();

        $this->assertEquals(
            "<title>$title - $siteName</title>",
            $this->head->title()->render()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function it_must_throw_invalid_type_exception_on_title()
    {
        $this->head->setTitle(true);
    }

    /** @test */
    public function it_can_set_and_get_description()
    {
        $description = 'Hello Description';
        $this->head->setDescription($description);

        $this->assertEquals($description, $this->head->description()->get());
        $this->assertEquals(
            '<meta name="description" content="' . $description . '"/>',
            $this->head->description()->render()
        );
    }

    /** @test */
    public function it_can_set_and_get_by_description_class()
    {
        $description = new Description;
        $description->set('Hello Description');
        $this->head->setDescription($description);

        $this->assertEquals('Hello Description', $this->head->description()->get());
        $this->assertEquals(
            '<meta name="description" content="Hello Description"/>',
            $this->head->description()->render()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function it_must_throw_invalid_type_exception_on_description()
    {
        $this->head->setDescription(true);
    }

    /** @test */
    public function it_can_set_and_get_keywords()
    {
        // Array Keywords
        $arrayKeywords  = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];

        $this->head->setKeywords($arrayKeywords);
        $this->assertEquals($arrayKeywords, $this->head->keywords()->get());

        // String Keywords
        $stringKeywords = implode(', ', $arrayKeywords);
        $keywordsTag    = '<meta name="keywords" content="' . $stringKeywords . '"/>';

        $this->head->setKeywords($stringKeywords);
        $this->assertEquals($arrayKeywords, $this->head->keywords()->get());
        $this->assertEquals($keywordsTag, $this->head->keywords()->render());
    }

    /** @test */
    public function it_set_and_get_by_keywords_class()
    {
        $arrayKeywords  = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];

        $keywords = (new Keywords)->set($arrayKeywords);

        $this->head->setKeywords($keywords);
        $keywordsTag = '<meta name="keywords" content="' . implode(', ', $arrayKeywords) . '"/>';

        $this->assertEquals($keywordsTag, $this->head->keywords()->render());
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function it_must_throw_invalid_type_exception_on_keywords()
    {
        $this->head->setKeywords(true);
    }

    /** @test */
    public function it_can_set_and_get_title_description_keywords()
    {
        $title       = 'Hello Title';
        $description = 'Hello Description';
        $keywords    = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];
        $this->head->set($title, $description, $keywords);

        $this->assertEquals($title,       $this->head->getTitle());
        $this->assertEquals($description, $this->head->description()->get());
        $this->assertEquals($keywords,    $this->head->keywords()->get());
    }

    /** @test */
    public function it_can_set_and_get_metas()
    {
        $this->assertEquals('', $this->head->metas()->render());

        $this->head->addMeta('author', 'ARCANEDEV');

        $this->assertCount(1, $this->head->metas());

        $meta = Meta::make('robots', 'noindex, nofollow');
        $this->head->setMeta($meta);

        $this->assertCount(2, $this->head->metas());
    }

    /** @test */
    public function it_can_get_open_graph_class()
    {
        $this->assertInstanceOf(OpenGraph::class, $this->head->openGraph());
    }

    /** @test */
    public function it_can_enable_and_disable_open_graph()
    {
        $this->assertFalse($this->head->isOpenGraphEnabled());

        $this->head->doFacebook();

        $this->assertTrue($this->head->isOpenGraphEnabled());

        $this->head->noFacebook();

        $this->assertFalse($this->head->isOpenGraphEnabled());
    }

    /** @test */
    public function it_can_get_twitter_card_class()
    {
        $this->assertInstanceOf(TwitterCard::class, $this->head->twitterCard());
    }

    /** @test */
    public function it_can_enable_and_disable_twitter_card()
    {
        $this->assertFalse($this->head->isTwitterCardEnabled());

        $this->head->doTwitterCard();

        $this->assertTrue($this->head->isTwitterCardEnabled());

        $this->head->noTwitterCard();

        $this->assertFalse($this->head->isTwitterCardEnabled());
    }

    /** @test */
    public function it_can_render_all()
    {
        $title         = 'Hello world';
        $description   = 'Description of the hello world';
        $arrayKeywords = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];
        $tagsArray     = [
            '<meta charset="UTF-8">',
            '<title>' . $title . '</title>',
            '<meta name="description" content="' . $description . '"/>',
            '<meta name="keywords" content="' . implode(', ', $arrayKeywords) .'"/>',
            '<link href="' . base_url('favicon.ico'). '" rel="icon" type="image/x-icon"/>',
            '<link href="' . base_url('favicon.png'). '" rel="icon" type="image/png"/>',
            '<meta name="author" content="ARCANEDEV"/>',
            '<meta name="robots" content="noindex, nofollow"/>',
        ];

        // SEO
        $this->head->setTitle($title);
        $this->head->setDescription($description);
        $this->head->setKeywords($arrayKeywords);
        // METAS
        $this->head->addMeta('author', 'ARCANEDEV');
        $meta = Meta::make('robots', 'noindex, nofollow');
        $this->head->setMeta($meta);


        $this->assertEquals(implode(PHP_EOL, $tagsArray), $this->head->render());
    }

    /** @test */
    public function it_can_add_and_render_styles()
    {
        $this->head->addStyle('assets/css/style.css');
        $this->head->addStyle('assets/css/bootstrap.min.css');

        $styles = implode(PHP_EOL, [
            '<link rel="stylesheet" href="assets/css/style.css">',
            '<link rel="stylesheet" href="assets/css/bootstrap.min.css">',
        ]);

        $this->assertEquals($styles, $this->head->styles());
    }

    /** @test */
    public function it_can_add_many_and_render_styles()
    {
        $this->head->addStyles([
            'assets/css/style.css',
            'assets/css/bootstrap.min.css',
        ]);

        $styles = implode(PHP_EOL, [
            '<link rel="stylesheet" href="assets/css/style.css">',
            '<link rel="stylesheet" href="assets/css/bootstrap.min.css">',
        ]);

        $this->assertEquals($styles, $this->head->styles());
    }

    /** @test */
    public function it_can_add_and_render_scripts()
    {
        $this->head->addScript('assets/js/jquery.min.js');
        $this->head->addScript('assets/js/bootstrap.min.js');

        $scripts = implode(PHP_EOL, [
            '<script src="assets/js/jquery.min.js"></script>',
            '<script src="assets/js/bootstrap.min.js"></script>'
        ]);

        $this->assertEquals($scripts, $this->head->scripts());
    }

    /** @test */
    public function it_can_add_many_and_render_scripts()
    {
        $this->head->addScripts([
            'assets/js/jquery.min.js',
            'assets/js/bootstrap.min.js'
        ]);

        $scripts = implode(PHP_EOL, [
            '<script src="assets/js/jquery.min.js"></script>',
            '<script src="assets/js/bootstrap.min.js"></script>'
        ]);

        $this->assertEquals($scripts, $this->head->scripts());
    }

    /** @test */
    public function it_can_add_favicon()
    {
        $this->head->setFavicon('favicon');

        $this->assertEquals(
            implode(PHP_EOL, [
                '<meta charset="UTF-8">',
                '<link href="favicon.ico" rel="icon" type="image/x-icon"/>',
                '<link href="favicon.png" rel="icon" type="image/png"/>',
            ])
            , $this->head->render()
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param \Arcanedev\Head\Support\Collection $config
     */
    private function assertConfig($config)
    {
        $this->assertInstanceOf(
            'Arcanedev\\Head\\Support\\Collection',
            $config
        );

        $this->assertEquals([
            'charset',
            'title',
            'description',
            'favicon',
            'html',
            'facebook',
            'twitter',
            'assets',
            'analytics'
        ], $config->keys());
    }
}
