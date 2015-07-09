<?php namespace Arcanedev\Head\Tests\Laravel;

use Arcanedev\Head\Entities\Charset;
use Arcanedev\Head\Entities\Description;
use Arcanedev\Head\Entities\Keywords;
use Arcanedev\Head\Entities\Meta;
use Arcanedev\Head\Entities\Title;
use Arcanedev\Head\Laravel\Facade as Head;
use Arcanedev\Head\Tests\LaravelTestCase;

/**
 * Class FacadeTest
 * @package Arcanedev\Head\Tests\Laravel
 */
class FacadeTest extends LaravelTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function test_can_get_default_charset()
    {
        $this->assertEquals('UTF-8', Head::charset()->get());
    }

    /** @test */
    public function test_can_get_default_config()
    {
        $config     = Head::getConfig();

        $this->assertConfig($config);
        $this->assertEquals('UTF-8', $config['charset']);
    }

    /** @test */
    public function test_can_set_and_get_config_from_array()
    {
        Head::setConfig([
            'charset' => 'ISO-8859-1',
        ]);

        $config = Head::getConfig();

        $this->assertConfig($config);
        $this->assertEquals('ISO-8859-1', $config->get('charset'));
        $this->assertEquals('ISO-8859-1', $config['charset']);
    }

    /** @test */
    public function test_can_set_and_get_config_from_file()
    {
        $path = realpath(__DIR__ . '/../data/config-valid.php');
        Head::configPath($path);

        $config = Head::getConfig();

        $this->assertConfig($config);
        $this->assertEquals('ISO-8859-1', $config->get('charset'));
        $this->assertEquals('ISO-8859-1', $config['charset']);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\FileNotFoundException
     */
    public function test_must_throw_file_not_found_exception_on_config_path()
    {
        Head::configPath(__DIR__ . '/data/config-not-found.php');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function test_must_throw_invalid_type_exception_on_config_path()
    {
        $path = realpath(__DIR__ . '/../data/config-invalid.php');
        Head::configPath($path);
    }

    /** @test */
    public function test_can_set_and_get_charset()
    {
        $this->assertEquals('UTF-8', Head::charset()->get());
        $this->assertEquals(
            '<meta charset="UTF-8">',
            Head::charset()->render()
        );

        Head::setCharset('ISO-8859-1');

        $this->assertEquals('ISO-8859-1', Head::charset()->get());
        $this->assertEquals(
            '<meta charset="ISO-8859-1">',
            Head::charset()->render()
        );

        Head::setCharset(Charset::make('UTF-8'));

        $this->assertEquals('UTF-8', Head::charset()->get());
        $this->assertEquals(
            '<meta charset="UTF-8">',
            Head::charset()->render()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function test_must_throw_invalid_type_exception_on_charset()
    {
        Head::setCharset(true);
    }

    /** @test */
    public function test_can_set_and_get_title()
    {
        $title = 'Hello Title';
        Head::setTitle($title);

        $this->assertEquals($title, Head::title()->get());
        $this->assertEquals(
            '<title>Hello Title</title>',
            Head::title()->render()
        );
    }

    /** @test */
    public function test_can_set_and_get_site_name()
    {
        $siteName = 'Company name';

        Head::setSiteName($siteName);

        $this->assertEquals($siteName, Head::getSiteName());
    }

    /** @test */
    public function test_can_set_and_get_by_title_class()
    {
        $title = new Title;
        $title->set('Hello Title')
            ->setSiteName('Company Name')
            ->separator('||');

        Head::setTitle($title);

        $this->assertEquals('Hello Title', Head::title()->get());
        $this->assertEquals(
            '<title>Hello Title || Company Name</title>',
            Head::title()->render()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function test_must_throw_invalid_type_exception_on_title()
    {
        Head::setTitle(true);
    }

    /** @test */
    public function test_can_set_and_get_description()
    {
        $description = 'Hello Description';
        Head::setDescription($description);

        $this->assertEquals($description, Head::description()->get());
        $this->assertEquals(
            '<meta name="description" content="' . $description . '"/>',
            Head::description()->render()
        );
    }

    /** @test */
    public function test_can_set_and_get_by_description_class()
    {
        $description = new Description;
        $description->set('Hello Description');
        Head::setDescription($description);

        $this->assertEquals('Hello Description', Head::description()->get());
        $this->assertEquals(
            '<meta name="description" content="Hello Description"/>',
            Head::description()->render()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function test_must_throw_invalid_type_exception_on_description()
    {
        Head::setDescription(true);
    }

    /** @test */
    public function test_can_set_and_get_keywords()
    {
        // Array Keywords
        $arrayKeywords  = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];

        Head::setKeywords($arrayKeywords);
        $this->assertEquals($arrayKeywords, Head::keywords()->get());

        // String Keywords
        $stringKeywords = implode(', ', $arrayKeywords);
        $keywordsTag    = '<meta name="keywords" content="' . $stringKeywords . '"/>';

        Head::setKeywords($stringKeywords);
        $this->assertEquals($arrayKeywords, Head::keywords()->get());
        $this->assertEquals($keywordsTag, Head::keywords()->render());
    }

    /** @test */
    public function test_set_and_get_by_keywords_class()
    {
        $arrayKeywords  = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];

        $keywords = (new Keywords)->set($arrayKeywords);

        Head::setKeywords($keywords);
        $keywordsTag = '<meta name="keywords" content="' . implode(', ', $arrayKeywords) . '"/>';

        $this->assertEquals($keywordsTag, Head::keywords()->render());
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function test_must_throw_invalid_type_exception_on_keywords()
    {
        Head::setKeywords(true);
    }

    /** @test */
    public function test_can_set_and_get_title_description_keywords()
    {
        $title       = 'Hello Title';
        $description = 'Hello Description';
        $keywords    = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];
        Head::set($title, $description, $keywords);

        $this->assertEquals($title,       Head::title()->get());
        $this->assertEquals($description, Head::description()->get());
        $this->assertEquals($keywords,    Head::keywords()->get());
    }

    /** @test */
    public function test_can_set_and_get_metas()
    {
        $this->assertEquals('', Head::metas()->render());

        Head::addMeta('author', 'ARCANEDEV');

        $this->assertCount(1, Head::metas());

        Head::setMeta(Meta::make('robots', 'noindex, nofollow'));

        $this->assertCount(2, Head::metas());
    }

    /** @test */
    public function test_can_enable_and_disable_open_graph()
    {
        $this->assertFalse(Head::isOpenGraphEnabled());

        Head::doFacebook();

        $this->assertTrue(Head::isOpenGraphEnabled());

        Head::noFacebook();

        $this->assertFalse(Head::isOpenGraphEnabled());
    }

    /** @test */
    public function test_can_render_all()
    {
        $title         = 'Hello world';
        $description   = 'Description of the hello world';
        $arrayKeywords = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];
        $tagsArray     = [
            '<meta charset="UTF-8">',
            '<title>' . $title . '</title>',
            '<meta name="description" content="' . $description . '"/>',
            '<meta name="keywords" content="' . implode(', ', $arrayKeywords) .'"/>',
            '<meta name="author" content="ARCANEDEV"/>',
            '<meta name="robots" content="noindex, nofollow"/>',
            '<link href="' . base_url('favicon.ico') . '" rel="icon" type="image/x-icon"/>',
            '<link href="' . base_url('favicon.png') . '" rel="icon" type="image/png"/>',
        ];

        // SEO
        Head::setTitle($title);
        Head::setDescription($description);
        Head::setKeywords($arrayKeywords);
        // METAS
        Head::addMeta('author', 'ARCANEDEV');
        $meta = Meta::make('robots', 'noindex, nofollow');
        Head::setMeta($meta);


        $this->assertEquals(implode(PHP_EOL, $tagsArray), Head::render());
    }

    /** @test */
    public function test_can_add_and_render_styles()
    {
        Head::addStyle('assets/css/style.css');
        Head::addStyle('assets/css/bootstrap.min.css');

        $styles = implode(PHP_EOL, [
            '<link rel="stylesheet" src="assets/css/style.css">',
            '<link rel="stylesheet" src="assets/css/bootstrap.min.css">',
        ]);

        $this->assertEquals($styles, Head::styles());
    }

    /** @test */
    public function test_can_add_many_and_render_styles()
    {
        Head::addStyles([
            'assets/css/style.css',
            'assets/css/bootstrap.min.css',
        ]);

        $styles = implode(PHP_EOL, [
            '<link rel="stylesheet" src="assets/css/style.css">',
            '<link rel="stylesheet" src="assets/css/bootstrap.min.css">',
        ]);

        $this->assertEquals($styles, Head::styles());
    }

    /** @test */
    public function test_can_add_and_render_scripts()
    {
        Head::addScript('assets/js/jquery.min.js');
        Head::addScript('assets/js/bootstrap.min.js');

        $scripts = implode(PHP_EOL, [
            '<script src="assets/js/jquery.min.js"></script>',
            '<script src="assets/js/bootstrap.min.js"></script>'
        ]);

        $this->assertEquals($scripts, Head::scripts());
    }

    /** @test */
    public function test_can_add_many_and_render_scripts()
    {
        Head::addScripts([
            'assets/js/jquery.min.js',
            'assets/js/bootstrap.min.js'
        ]);

        $scripts = implode(PHP_EOL, [
            '<script src="assets/js/jquery.min.js"></script>',
            '<script src="assets/js/bootstrap.min.js"></script>'
        ]);

        $this->assertEquals($scripts, Head::scripts());
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
