<?php namespace Arcanedev\Head\Tests\Laravel;

use Arcanedev\Head\Entities\Charset;
use Arcanedev\Head\Entities\Description;
use Arcanedev\Head\Entities\Keywords;
use Arcanedev\Head\Entities\Meta;
use Arcanedev\Head\Entities\Title;
use Arcanedev\Head\Laravel\Facade as Head;
use Arcanedev\Head\Tests\LaravelTestCase;

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
    /**
     * @test
     */
    public function testCanGetDefaultCharset()
    {
        $this->assertEquals('UTF-8', Head::getCharset());
    }

    /**
     * @test
     */
    public function testCanGetDefaultConfig()
    {
        $config     = Head::getConfig();

        $this->assertConfig($config);
        $this->assertEquals('UTF-8', $config['charset']);
    }

    /**
     * @test
     */
    public function testCanSetAndGetConfigFromArray()
    {
        Head::loadConfig([
            'charset' => 'ISO-8859-1',
        ]);

        $config = Head::getConfig();

        $this->assertConfig($config);
        $this->assertEquals('ISO-8859-1', $config->get('charset'));
        $this->assertEquals('ISO-8859-1', $config['charset']);
    }

    /**
     * @test
     */
    public function testCanSetAndGetConfigFromFile()
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
    public function testMustThrowFileNotFoundExceptionOnConfigPath()
    {
        Head::configPath(__DIR__ . '/data/config-not-found.php');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnConfigPath()
    {
        $path = realpath(__DIR__ . '/../data/config-invalid.php');
        Head::configPath($path);
    }

    /**
     * @test
     */
    public function testCanSetAndGetCharset()
    {
        $this->assertEquals('UTF-8', Head::getCharset());
        $this->assertEquals(
            '<meta charset="UTF-8">',
            Head::renderCharsetTag()
        );

        Head::setCharset('ISO-8859-1');

        $this->assertEquals('ISO-8859-1', Head::getCharset());
        $this->assertEquals(
            '<meta charset="ISO-8859-1">',
            Head::renderCharsetTag()
        );

        Head::setCharset(Charset::make('UTF-8'));

        $this->assertEquals('UTF-8', Head::getCharset());
        $this->assertEquals(
            '<meta charset="UTF-8">',
            Head::renderCharsetTag()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnCharset()
    {
        Head::setCharset(true);
    }

    /**
     * @test
     */
    public function canSetAndGetTitle()
    {
        $title = 'Hello Title';
        Head::setTitle($title);

        $this->assertEquals($title, Head::getTitle());
        $this->assertEquals(
            '<title>Hello Title</title>',
            Head::renderTitleTag()
        );
    }

    /**
     * @test
     */
    public function canSetAndGetSiteName()
    {
        $siteName = 'Company name';

        Head::setSiteName($siteName);

        $this->assertEquals($siteName, Head::getSiteName());
    }

    /**
     * @test
     */
    public function canSetAndGetByTitleClass()
    {
        $title = new Title;
        $title->set('Hello Title')
            ->setSiteName('Company Name')
            ->separator('||');

        Head::setTitle($title);

        $this->assertEquals('Hello Title', Head::getTitle());
        $this->assertEquals(
            '<title>Hello Title || Company Name</title>',
            Head::renderTitleTag()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnTitle()
    {
        Head::setTitle(true);
    }

    /**
     * @test
     */
    public function canSetAndGetDescription()
    {
        $description = 'Hello Description';
        Head::setDescription($description);

        $this->assertEquals($description, Head::getDescription());
        $this->assertEquals(
            '<meta name="description" content="' . $description . '"/>',
            Head::renderDescriptionTag()
        );
    }

    /**
     * @test
     */
    public function canSetAndGetByDescriptionClass()
    {
        $description = new Description;
        $description->set('Hello Description');
        Head::setDescription($description);

        $this->assertEquals('Hello Description', Head::getDescription());
        $this->assertEquals(
            '<meta name="description" content="Hello Description"/>',
            Head::renderDescriptionTag()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnDescription()
    {
        Head::setDescription(true);
    }

    /**
     * @test
     */
    public function canSetAndGetKeywords()
    {
        // Array Keywords
        $arrayKeywords  = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];

        Head::setKeywords($arrayKeywords);
        $this->assertEquals($arrayKeywords, Head::getKeywords());

        // String Keywords
        $stringKeywords = implode(', ', $arrayKeywords);
        $keywordsTag    = '<meta name="keywords" content="' . $stringKeywords . '"/>';

        $this->assertEquals($arrayKeywords, Head::setKeywords($stringKeywords)->getKeywords());
        $this->assertEquals($keywordsTag, Head::renderKeywordsTag());
    }

    /**
     * @test
     */
    public function testSetAndGetByKeywordsClass()
    {
        $arrayKeywords  = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];

        $keywords = (new Keywords)->set($arrayKeywords);

        Head::setKeywords($keywords);
        $keywordsTag = '<meta name="keywords" content="' . implode(', ', $arrayKeywords) . '"/>';

        $this->assertEquals($keywordsTag, Head::renderKeywordsTag());
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnKeywords()
    {
        Head::setKeywords(true);
    }

    /**
     * @test
     */
    public function testCanSetAndGetTitleDescriptionKeywords()
    {
        $title       = 'Hello Title';
        $description = 'Hello Description';
        $keywords    = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];
        Head::set($title, $description, $keywords);

        $this->assertEquals($title,       Head::getTitle());
        $this->assertEquals($description, Head::getDescription());
        $this->assertEquals($keywords,    Head::getKeywords());
    }

    /**
     * @test
     */
    public function testCanSetAndGetMetas()
    {
        $this->assertEquals('', Head::renderMetasTags());

        Head::addMeta('author', 'ARCANEDEV');

        $this->assertCount(1, Head::getMetas());

        $meta = Meta::make('robots', 'noindex, nofollow');
        Head::setMeta($meta);

        $this->assertCount(2, Head::getMetas());
    }

    /**
     * @test
     */
    public function testCanEnableAndDisableOpenGraph()
    {
        $this->assertFalse(Head::isOpenGraphEnabled());

        Head::doFacebook();

        $this->assertTrue(Head::isOpenGraphEnabled());

        Head::noFacebook();

        $this->assertFalse(Head::isOpenGraphEnabled());
    }

    /**
     * @test
     */
    public function testCanRenderAll()
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

    /**
     * @test
     */
    public function testCanAddAndRenderStyles()
    {
        Head::addStyle('assets/css/style.css');
        Head::addStyle('assets/css/bootstrap.min.css');

        $styles = implode(PHP_EOL, [
            '<link rel="stylesheet" src="assets/css/style.css">',
            '<link rel="stylesheet" src="assets/css/bootstrap.min.css">',
        ]);

        $this->assertEquals($styles, Head::renderStylesTags());
    }

    /**
     * @test
     */
    public function testCanAddManyAndRenderStyles()
    {
        Head::addStyles([
            'assets/css/style.css',
            'assets/css/bootstrap.min.css',
        ]);

        $styles = implode(PHP_EOL, [
            '<link rel="stylesheet" src="assets/css/style.css">',
            '<link rel="stylesheet" src="assets/css/bootstrap.min.css">',
        ]);

        $this->assertEquals($styles, Head::renderStylesTags());
        $this->assertEquals($styles, Head::styles());
    }

    /**
     * @test
     */
    public function testCanAddAndRenderScripts()
    {
        Head::addScript('assets/js/jquery.min.js');
        Head::addScript('assets/js/bootstrap.min.js');

        $scripts = implode(PHP_EOL, [
            '<script src="assets/js/jquery.min.js"></script>',
            '<script src="assets/js/bootstrap.min.js"></script>'
        ]);

        $this->assertEquals($scripts, Head::renderScriptsTags());
        $this->assertEquals($scripts, Head::scripts());
    }

    /**
     * @test
     */
    public function testCanAddManyAndRenderScripts()
    {
        Head::addScripts([
            'assets/js/jquery.min.js',
            'assets/js/bootstrap.min.js'
        ]);

        $scripts = implode(PHP_EOL, [
            '<script src="assets/js/jquery.min.js"></script>',
            '<script src="assets/js/bootstrap.min.js"></script>'
        ]);

        $this->assertEquals($scripts, Head::renderScriptsTags());
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
