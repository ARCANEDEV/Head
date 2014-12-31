<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\TitleInterface         as TitleInterface;
use Arcanedev\Head\Contracts\RenderableInterface    as RenderableInterface;

use Arcanedev\Head\Exceptions\EmptyTitleException   as EmptyTitleException;
use Arcanedev\Head\Exceptions\InvalidTypeException  as InvalidTypeException;

class Title implements TitleInterface, RenderableInterface
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

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    function __construct(array $config = [])
    {
        $this->title    = '';
        $this->siteName = '';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return string
     */
    public function get()
    {
        return $this->getTitle();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
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
     * @param string $siteName
     *
     * @throws InvalidTypeException
     *
     * @return Title|string
     */
    public function siteName($siteName = '')
    {
        $this->checkIsString('site name', $siteName);

        $siteName = trim($siteName);

        return empty($siteName)
            ? $this->getSitename()
            : $this->setSiteName($siteName);
    }

    /**
     * @param string $siteName
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
     * @return string
     */
    public function getSiteName()
    {
        return $this->siteName;
    }

    /**
     * @return Title
     */
    public function hideSiteName()
    {
        return $this->setSiteNameVisibility(false);
    }

    /**
     * @return Title
     */
    public function showSiteName()
    {
        return $this->setSiteNameVisibility(true);
    }

    /**
     * @param bool $visible
     *
     * @return Title
     */
    private function setSiteNameVisibility($visible = true)
    {
        $this->siteNameVisible = $visible;

        return $this;
    }

    /**
     * @return Title
     */
    public function siteNameFirst()
    {
        return $this->setSiteNamePosition(true);
    }

    /**
     * @return Title
     */
    public function siteNameLast()
    {
        return $this->setSiteNamePosition(false);
    }

    /**
     * @param bool $first
     *
     * @return Title
     */
    private function setSiteNamePosition($first = false)
    {
        $this->siteNameFirst = $first;

        return $this;
    }

    /**
     * @param string $separator
     *
     * @throws InvalidTypeException
     *
     * @return Title|string
     */
    public function separator($separator = '')
    {
        $this->checkIsString('separator', $separator);

        $separator = trim($separator);

        return empty($separator)
            ? $this->getSeparator()
            : $this->setSeparator($separator);
    }

    /**
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param string $separator
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

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render title html tag
     *
     * @return string
     */
    public function render()
    {
        if ( $this->isEmpty() ) {
            return '';
        }

        $title = [];
        $this->getFirst($title);
        $this->renderSeparator($title);
        $this->getLast($title);

        return '<title>' . implode(' ', $title) . '</title>';
    }

    /**
     * @param array $title
     */
    private function getFirst(&$title)
    {
        if ( $this->checkSiteName() and $this->isSiteNameFirst() ) {
            $this->renderSiteName($title);

            return;
        }

        $this->renderTitle($title);
    }

    /**
     * @param array $title
     */
    private function getLast(&$title)
    {
        if ( ! $this->checkSiteName() ) {
            return;
        }

        if ( ! $this->isSiteNameFirst() ) {
            $this->renderSiteName($title);

            return;
        }

        $this->renderTitle($title);
    }

    /**
     * @param array $title
     */
    private function renderTitle(&$title)
    {
        $title[] = $this->get();
    }

    /**
     * @param array $title
     */
    private function renderSiteName(&$title)
    {
        if ( $this->checkSiteName() ) {
            $title[] = $this->getSitename();
        }
    }

    /**
     * @param array $title
     */
    private function renderSeparator(&$title)
    {
        if ( $this->checkSeparator() ) {
            $title[] = $this->getSeparator();
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->title);
    }

    /**
     * @return bool
     */
    public function isSiteNameEmpty()
    {
        return empty($this->siteName);
    }

    /**
     * @return bool
     */
    public function isSiteNameVisible()
    {
        return $this->siteNameVisible;
    }

    /**
     * @return bool
     */
    public function isSiteNameHidden()
    {
        return ! $this->isSiteNameVisible();
    }

    /**
     * @return bool
     */
    public function isSiteNameFirst()
    {
        return $this->siteNameFirst;
    }

    /**
     * @return bool
     */
    private function checkSiteName()
    {
        return ! $this->isSiteNameEmpty() and $this->isSiteNameVisible();
    }

    /**
     * @return bool
     */
    public function isSeparatorEmpty()
    {
        return empty($this->separator);
    }

    /**
     * @return bool
     */
    private function checkSeparator()
    {
        return ! $this->isSeparatorEmpty() and $this->checkSiteName();
    }

    /**
     * @param string $title
     *
     * @throws EmptyTitleException
     * @throws InvalidTypeException
     */
    private function checkTitle(&$title)
    {
        $this->checkIsString('title', $title);

        $title = trim($title);

        if ( empty($title) ) {
            throw new EmptyTitleException('The title is empty !');
        }
    }

    /**
     * Check if the value is a string value
     *
     * @param string $name
     * @param mixed  $value
     *
     * @throws InvalidTypeException
     */
    private function checkIsString($name, $value)
    {
        if ( ! is_string($value) ) {
            throw new InvalidTypeException($name, $value);
        }
    }
}
