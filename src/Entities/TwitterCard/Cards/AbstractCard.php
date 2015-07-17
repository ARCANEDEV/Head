<?php namespace Arcanedev\Head\Entities\TwitterCard\Cards;

use Arcanedev\Head\Contracts\Renderable;

/**
 * Class AbstractCard
 * @package Arcanedev\Head\Entities\TwitterCard\Cards
 */
abstract class AbstractCard implements Renderable
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     *
     * @var string
     */
    protected $card;

    /**
     * The Twitter @username the card should be attributed to.
     *
     * @var string
     */
    protected $site        = '';

    /**
     * Title should be concise and will be truncated at 70 characters.
     *
     * @var string
     */
    protected $title       = '';

    /**
     * @var array
     */
    protected $baseRequired = [
        'site', 'title',
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {

    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get card type
     *
     * @return string
     */
    public function getType()
    {
        return $this->card;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set site
     *
     * @param  string $site
     *
     * @return self
     */
    public function setSite($site)
    {
        $this->checkSite($site);

        $this->site = $site;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param  string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->checkTitle($title);
        $this->title = $title;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->site) || empty($this->title);
    }

    /**
     * Check site
     *
     * @param string $site
     */
    private function checkSite(&$site)
    {
        if (empty($site)) {
            throw new \InvalidArgumentException(
                'The site attribute must not be empty.'
            );
        }

        if ( ! starts_with($site, '@')) {
            $site = '@' . $site;
        }
    }

    /**
     * Check title
     *
     * @param string $title
     */
    private function checkTitle(&$title)
    {
        if (empty($title)) {
            throw new \InvalidArgumentException(
                'The title attribute must not be empty.'
            );
        }

        $title = $this->truncate($title, 70);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Truncate text
     *
     * @param  string $text
     * @param  int    $max
     * @param  string $end
     *
     * @return string
     */
    protected function truncate($text, $max, $end = '...')
    {
        return str_limit($text, $max - strlen($end), $end);
    }
}
