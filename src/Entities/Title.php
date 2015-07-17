<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\Entities\TitleInterface;
use Arcanedev\Head\Contracts\Renderable;
use Arcanedev\Head\Exceptions\EmptyTitleException;
use Arcanedev\Head\Exceptions\InvalidTypeException;
use Arcanedev\Markup\Entities\Tag;
use Arcanedev\Markup\Markup;

/**
 * Class Title
 * @package Arcanedev\Head\Entities
 */
class Title implements TitleInterface, Renderable
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $siteName;

    /**
     * @var bool
     */
    protected $siteNameVisible = true;

    /**
     * @var bool
     */
    protected $siteNameFirst   = false;

    /**
     * @var string
     */
    protected $separator       = '|';

    /**
     * @var Tag
     */
    private $tag;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct($title = '', $siteName = '')
    {
        $this->title    = $title;
        $this->siteName = $siteName;
        $this->tag      = Markup::title();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Title
     *
     * @return string
     */
    public function get()
    {
        return $this->getTitle();
    }

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set Title
     *
     * @param  string $title
     *
     * @throws InvalidTypeException
     * @throws EmptyTitleException
     *
     * @return Title
     */
    public function set($title)
    {
        $this->checkTitle($title);
        $this->title = $title;

        return $this;
    }

    /**
     * Set or Get Site Name
     *
     * @param  string $siteName
     *
     * @throws InvalidTypeException
     *
     * @return Title|string
     */
    public function siteName($siteName = '')
    {
        $this->checkIsString('site name', $siteName);

        return empty($siteName = trim($siteName))
            ? $this->getSitename()
            : $this->setSiteName($siteName);
    }

    /**
     * Set Site Name
     *
     * @param  string $siteName
     *
     * @throws InvalidTypeException
     *
     * @return Title
     */
    public function setSiteName($siteName)
    {
        $this->checkIsString('site name', $siteName);
        $this->siteName = trim($siteName);

        return $this;
    }

    /**
     * Get Site Name
     *
     * @return string
     */
    public function getSiteName()
    {
        return $this->siteName;
    }

    /**
     * Hide Site Name
     *
     * @return Title
     */
    public function hideSiteName()
    {
        return $this->setSiteNameVisibility(false);
    }

    /**
     * Show Site Name
     *
     * @return Title
     */
    public function showSiteName()
    {
        return $this->setSiteNameVisibility(true);
    }

    /**
     * Set Site Name visibility
     *
     * @param  bool $visible
     *
     * @return Title
     */
    private function setSiteNameVisibility($visible = true)
    {
        $this->siteNameVisible = $visible;

        return $this;
    }

    /**
     * Set Site Name first
     *
     * @return Title
     */
    public function siteNameFirst()
    {
        return $this->setSiteNamePosition(true);
    }

    /**
     * Set Site Name last
     *
     * @return Title
     */
    public function siteNameLast()
    {
        return $this->setSiteNamePosition(false);
    }

    /**
     * Set Site Name Position
     *
     * @param  bool $first
     *
     * @return Title
     */
    private function setSiteNamePosition($first = false)
    {
        $this->siteNameFirst = $first;

        return $this;
    }

    /**
     * Set or Get Separator
     *
     * @param  string $separator
     *
     * @throws InvalidTypeException
     *
     * @return Title|string
     */
    public function separator($separator = '')
    {
        $this->checkIsString('separator', $separator);

        return empty($separator = trim($separator))
            ? $this->getSeparator()
            : $this->setSeparator($separator);
    }

    /**
     * Get Separator
     *
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * Set title separator
     *
     * @param  string $separator
     *
     * @throws InvalidTypeException
     *
     * @return Title
     */
    public function setSeparator($separator = '|')
    {
        $this->checkIsString('separator', $separator);
        $this->separator = trim($separator);

        return $this;
    }

    /**
     * Set config
     *
     * @param  array $config
     *
     * @return Title
     */
    public function setConfig(array $config)
    {
        // TODO: Add check config method
        $this->setSeparator($config['separator']);

        $config['first'] ? $this->siteNameLast() : $this->siteNameFirst();

        $this->setSiteName($config['site-name']['content']);
        $this->setSiteNameVisibility($config['site-name']['enabled']);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render Title tag
     *
     * @return string
     */
    public function render()
    {
        if ($this->isEmpty()) {
            return '';
        }

        $title = [];

        $this->getFirst($title);
        $this->renderSeparator($title);
        if ($this->checkSiteName()) {
            $this->getLast($title);
        }

        $this->tag->setText(implode(' ', $title));

        return $this->tag->render();
    }

    /**
     * Get First Element
     *
     * @param array $title
     */
    private function getFirst(&$title)
    {
        $title[] = ($this->checkSiteName() && $this->isSiteNameFirst())
            ? $this->getSitename()
            : $this->get();
    }

    /**
     * Get Last Element
     *
     * @param array $title
     */
    private function getLast(&$title)
    {
        $title[] = $this->isSiteNameFirst()
            ? $this->get()
            : $this->getSitename();
    }

    /**
     * Render Separator
     *
     * @param array $title
     */
    private function renderSeparator(&$title)
    {
        if ($this->checkSeparator()) {
            $title[] = $this->getSeparator();
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if Title is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->title);
    }

    /**
     * Check if Site Name is empty
     *
     * @return bool
     */
    public function isSiteNameEmpty()
    {
        return empty($this->siteName);
    }

    /**
     * Check if Site Name is visible
     *
     * @return bool
     */
    public function isSiteNameVisible()
    {
        return $this->siteNameVisible;
    }

    /**
     * Check if Site Name is hidden
     *
     * @return bool
     */
    public function isSiteNameHidden()
    {
        return ! $this->isSiteNameVisible();
    }

    /**
     * Check if Site Name is First
     *
     * @return bool
     */
    public function isSiteNameFirst()
    {
        return $this->siteNameFirst;
    }

    /**
     * Check Site Name is renderable
     *
     * @return bool
     */
    private function checkSiteName()
    {
        return ! $this->isSiteNameEmpty() && $this->isSiteNameVisible();
    }

    /**
     * Check if Separator is Renderable
     *
     * @return bool
     */
    private function checkSeparator()
    {
        return ! $this->isSeparatorEmpty() && $this->checkSiteName();
    }

    /**
     * Check if Separator is empty
     *
     * @return bool
     */
    public function isSeparatorEmpty()
    {
        return empty($this->separator);
    }

    /**
     * Check Title
     *
     * @param  string $title
     *
     * @throws EmptyTitleException
     * @throws InvalidTypeException
     */
    private function checkTitle(&$title)
    {
        $this->checkIsString('title', $title);

        $title = trim($title);

        if (empty($title)) {
            throw new EmptyTitleException('The title is empty !');
        }
    }

    /**
     * Check if the value is a string value
     *
     * @param  string $name
     * @param  string $value
     *
     * @throws InvalidTypeException
     */
    private function checkIsString($name, $value)
    {
        if ( ! is_string($value)) {
            throw new InvalidTypeException($name, $value);
        }
    }
}
