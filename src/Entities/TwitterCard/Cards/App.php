<?php namespace Arcanedev\Head\Entities\TwitterCard\Cards;

use Arcanedev\Head\Entities\TwitterCard\TwitterMetaBuilder as Builder;

/**
 * Class App
 * @package Arcanedev\Head\Entities\TwitterCard\Cards
 *
 * @link https://dev.twitter.com/cards/types/app
 */
class App extends AbstractCard
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Twitter card type
     *
     * @var string
     */
    protected $card = 'app';

    /**
     * The Twitter @username the card should be attributed to.
     *
     * @var string
     */
    protected $site        = '';

    /**
     * A description that concisely summarizes the content of the page,
     * as appropriate for presentation within a Tweet.
     * Do not re-use the title text as the description, or use this field
     * to describe the general services provided by the website.
     * Description text will be truncated at the word to 200 characters.
     *
     * @var string
     */
    protected $description = '';

    /**
     * @var array
     */
    protected $app         = [];

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param  string $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->checkDescription($description);
        $this->description = $description;

        return $this;
    }

    /**
     * Get app
     *
     * @return array
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * Set App
     * @param  array $app
     *
     * @return self
     */
    public function setApp(array $app)
    {
        $this->checkApp($app);
        $this->app = $app;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render the entity
     *
     * @return string
     */
    public function render()
    {
        if ($this->isEmpty()) {
            return '';
        }

        $attributes = array_intersect_key(get_object_vars($this), array_flip([
            'card',
            'site',
            'description',
            'app',
        ]));

        return Builder::html($attributes);
    }

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
        return parent::isEmpty() || empty($this->description);
    }

    /**
     * Check description
     *
     * @param string $description
     */
    private function checkDescription(&$description)
    {
        if ( ! empty($description)) {
            $description = $this->truncate($description, 200);
        }
    }

    /**
     * @param array $app
     */
    private function checkApp(array $app)
    {
        if ( ! isset($app['id'])) {
            throw new \InvalidArgumentException(
                'The app must provide the ids.'
            );
        }

        $missing = array_diff(
            ['iphone', 'ipad', 'googleplay'],
            array_keys($app['id'])
        );

        if (count($missing)) {
            throw new \InvalidArgumentException(
                'The app must provide the ids for ['. implode(', ', $missing) .'].'
            );
        }
    }
}
