<?php namespace Arcanedev\Head\Entities\TwitterCard\Cards;

use Arcanedev\Head\Entities\TwitterCard\TwitterMetaBuilder as Builder;

/**
 * Class Summary
 * @package Arcanedev\Head\Entities\TwitterCard\Cards
 *
 * @link https://dev.twitter.com/cards/types/summary
 */
class Summary extends AbstractCard
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var string */
    protected $card = 'summary';

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
     * URL to a unique image representing the content of the page.
     * Do not use a generic image such as your website logo, author photo, or other image that
     * spans multiple pages.
     * The image must be a minimum size of 120px by 120px and must be less than 1MB in file size.
     * For an expanded tweet and its detail page, the image will be cropped to a 4:3 aspect ratio
     * and resized to be displayed at 120px by 90px. The image will also be cropped and resized
     * to 120px by 120px for use in embedded tweets.
     *
     * @var string
     */
    protected $image = '';

    /* ------------------------------------------------------------------------------------------------
     |  Getters and Setters
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
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set image
     *
     * @param  string $image
     *
     * @return self
     */
    public function setImage($image)
    {
        $this->image = $image;

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
            'title',
            'description',
            'image',
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
        return parent::isEmpty() || empty($this->title) || empty($this->description);
    }

    /**
     * Check description
     *
     * @param string $description
     */
    private function checkDescription(&$description)
    {
        if (empty($description)) {
            throw new \InvalidArgumentException(
                'The description attribute must not be empty.'
            );
        }

        $description = $this->truncate($description, 200);
    }
}
