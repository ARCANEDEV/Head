<?php namespace Arcanedev\Head\Tests;

use Arcanedev\Head\Entities\Meta;
use Arcanedev\Head\Head;

use Arcanedev\Head\Entities\Charset     as Charset;
use Arcanedev\Head\Entities\Title       as Title;
use Arcanedev\Head\Entities\Description as Description;
use Arcanedev\Head\Entities\Keywords    as Keywords;

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
    /**
     * @test
     */
    public function testCanInstantiate()
    {
        $this->assertInstanceOf('Arcanedev\\Head\\Head', $this->head);
        $this->assertEquals('UTF-8', $this->head->getCharset());
    }

    /**
     * @test
     */
    public function testCanGetDefaultConfig()
    {
        $config     = $this->head->getConfig();

        $this->assertConfig($config);
        $this->assertEquals('UTF-8', $config['charset']);
    }

    /**
     * @test
     */
    public function testCanSetAndGetConfigFromArray()
    {
        $this->head->loadConfig([
            'charset' => 'ISO-8859-1',
        ]);

        $config = $this->head->getConfig();

        $this->assertConfig($config);
        $this->assertEquals('ISO-8859-1', $config->get('charset'));
        $this->assertEquals('ISO-8859-1', $config['charset']);
    }

    /**
     * @test
     */
    public function testCanSetAndGetConfigFromFile()
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
    public function testMustThrowFileNotFoundExceptionOnConfigPath()
    {
        $this->head->configPath(__DIR__ . '/data/config-not-found.php');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnConfigPath()
    {
        $this->head->configPath(__DIR__ . '/data/config-invalid.php');
    }

    /**
     * @test
     */
    public function testCanSetAndGetCharset()
    {
        $this->assertEquals('UTF-8', $this->head->getCharset());
        $this->assertEquals(
            '<meta charset="UTF-8">',
            $this->head->renderCharsetTag()
        );

        $this->head->setCharset('ISO-8859-1');

        $this->assertEquals('ISO-8859-1', $this->head->getCharset());
        $this->assertEquals(
            '<meta charset="ISO-8859-1">',
            $this->head->renderCharsetTag()
        );

        $this->head->setCharset(Charset::make('UTF-8'));

        $this->assertEquals('UTF-8', $this->head->getCharset());
        $this->assertEquals(
            '<meta charset="UTF-8">',
            $this->head->renderCharsetTag()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnCharset()
    {
        $this->head->setCharset(true);
    }

    /**
     * @test
     */
    public function canSetAndGetTitle()
    {
        $title = 'Hello Title';
        $this->head->setTitle($title);

        $this->assertEquals($title, $this->head->getTitle());
        $this->assertEquals(
            '<title>Hello Title</title>',
            $this->head->renderTitleTag()
        );
    }

    /**
     * @test
     */
    public function canSetAndGetSiteName()
    {
        $siteName = 'Company name';

        $this->head->setSiteName($siteName);

        $this->assertEquals($siteName, $this->head->getSiteName());
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

        $this->head->setTitle($title);

        $this->assertEquals('Hello Title', $this->head->getTitle());
        $this->assertEquals(
            '<title>Hello Title || Company Name</title>',
            $this->head->renderTitleTag()
        );
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnTitle()
    {
        $this->head->setTitle(true);
    }

    /**
     * @test
     */
    public function canSetAndGetDescription()
    {
        $description = 'Hello Description';
        $this->head->setDescription($description);

        $this->assertEquals($description, $this->head->getDescription());
        $this->assertEquals('<meta name="description" content="' . $description . '">', $this->head->renderDescriptionTag());
    }

    /**
     * @test
     */
    public function canSetAndGetByDescriptionClass()
    {
        $description = new Description;
        $description->set('Hello Description');
        $this->head->setDescription($description);

        $this->assertEquals('Hello Description', $this->head->getDescription());
        $this->assertEquals('<meta name="description" content="Hello Description">', $this->head->renderDescriptionTag());
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnDescription()
    {
        $this->head->setDescription(true);
    }

    /**
     * @test
     */
    public function canSetAndGetKeywords()
    {
        // Array Keywords
        $arrayKeywords  = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];

        $this->head->setKeywords($arrayKeywords);
        $this->assertEquals($arrayKeywords, $this->head->getKeywords());

        // String Keywords
        $stringKeywords = implode(', ', $arrayKeywords);
        $keywordsTag    = '<meta name="keywords" content="' . $stringKeywords . '">';

        $this->assertEquals($arrayKeywords, $this->head->setKeywords($stringKeywords)->getKeywords());
        $this->assertEquals($keywordsTag, $this->head->renderKeywordsTag());
    }

    /**
     * @test
     */
    public function testSetAndGetByKeywordsClass()
    {
        $arrayKeywords  = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];

        $keywords = (new Keywords)->set($arrayKeywords);

        $this->head->setKeywords($keywords);
        $keywordsTag = '<meta name="keywords" content="' . implode(', ', $arrayKeywords) . '">';

        $this->assertEquals($keywordsTag, $this->head->renderKeywordsTag());
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Head\Exceptions\InvalidTypeException
     */
    public function testMustThrowInvalidTypeExceptionOnKeywords()
    {
        $this->head->setKeywords(true);
    }

    /**
     * @test
     */
    public function testCanSetAndGetTitleDescriptionKeywords()
    {
        $title       = 'Hello Title';
        $description = 'Hello Description';
        $keywords    = ['keyword 1', 'keyword 2', 'keyword 3', 'keyword 4', 'keyword 5'];
        $this->head->set($title, $description, $keywords);

        $this->assertEquals($title,       $this->head->getTitle());
        $this->assertEquals($description, $this->head->getDescription());
        $this->assertEquals($keywords,    $this->head->getKeywords());
    }

    /**
     * @test
     */
    public function testCanSetAndGetMetas()
    {
        $this->assertEquals('', $this->head->renderMetasTags());

        $this->head->addMeta('author', 'ARCANEDEV');

        $this->assertCount(1, $this->head->getMetas());

        $meta = Meta::make('robots', 'noindex, nofollow');
        $this->head->setMeta($meta);

        $this->assertCount(2, $this->head->getMetas());
    }

    /**
     * @test
     */
    public function testCanEnableAndDisableOpenGraph()
    {
        $this->assertFalse($this->head->isOpenGraphEnabled());

        $this->head->doFacebook();

        $this->assertTrue($this->head->isOpenGraphEnabled());

        $this->head->noFacebook();

        $this->assertFalse($this->head->isOpenGraphEnabled());
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
            '<meta name="description" content="' . $description . '">',
            '<meta name="keywords" content="' . implode(', ', $arrayKeywords) .'">',
            '<meta name="author" content="ARCANEDEV">',
            '<meta name="robots" content="noindex, nofollow">',
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

    /**
     * @test
     */
    public function testCanAddAndRenderStyles()
    {
        $this->head->addStyle('assets/css/style.css');
        $this->head->addStyle('assets/css/bootstrap.min.css');

        $styles = implode(PHP_EOL, [
            '<link rel="stylesheet" src="assets/css/style.css">',
            '<link rel="stylesheet" src="assets/css/bootstrap.min.css">',
        ]);

        $this->assertEquals($styles, $this->head->renderStylesTags());
    }

    /**
     * @test
     */
    public function testCanAddManyAndRenderStyles()
    {
        $this->head->addStyles([
            'assets/css/style.css',
            'assets/css/bootstrap.min.css',
        ]);

        $styles = implode(PHP_EOL, [
            '<link rel="stylesheet" src="assets/css/style.css">',
            '<link rel="stylesheet" src="assets/css/bootstrap.min.css">',
        ]);

        $this->assertEquals($styles, $this->head->renderStylesTags());
        $this->assertEquals($styles, $this->head->styles());
    }

    /**
     * @test
     */
    public function testCanAddAndRenderScripts()
    {
        $this->head->addScript('assets/js/jquery.min.js');
        $this->head->addScript('assets/js/bootstrap.min.js');

        $scripts = implode(PHP_EOL, [
            '<script src="assets/js/jquery.min.js"></script>',
            '<script src="assets/js/bootstrap.min.js"></script>'
        ]);

        $this->assertEquals($scripts, $this->head->renderScriptsTags());
        $this->assertEquals($scripts, $this->head->scripts());
    }

    /**
     * @test
     */
    public function testCanAddManyAndRenderScripts()
    {
        $this->head->addScripts([
            'assets/js/jquery.min.js',
            'assets/js/bootstrap.min.js'
        ]);

        $scripts = implode(PHP_EOL, [
            '<script src="assets/js/jquery.min.js"></script>',
            '<script src="assets/js/bootstrap.min.js"></script>'
        ]);

        $this->assertEquals($scripts, $this->head->renderScriptsTags());
        $this->assertEquals($scripts, $this->head->scripts());
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
