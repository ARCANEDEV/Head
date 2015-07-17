<?php namespace Arcanedev\Head\Entities\TwitterCard\Cards;

use Arcanedev\Head\Entities\TwitterCard\TwitterMetaBuilder as Builder;

/**
 * Class Photo
 * @package Arcanedev\Head\Entities\TwitterCard\Cards
 *
 * @link https://dev.twitter.com/cards/types/photo
 */
class Photo extends AbstractCard
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
    protected $card = 'photo';

    /**
     * The Twitter @username the card should be attributed to.
     *
     * @var string
     */
    protected $site        = '';

    /**
     * @username of content creator
     *
     * @var string
     */
    protected $creator = '';

    /**
     * Title should be concise and will be truncated at 70 characters.
     *
     * @var string
     */
    protected $title       = '';

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

    /**
     * @var string
     */
    protected $url   = '';

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get creator username
     *
     * @return string
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set creator username
     *
     * @param  string $creator
     *
     * @return self
     */
    public function setCreator($creator)
    {
        $this->checkCreator($creator);
        $this->creator = $creator;

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

    /**
     * Set URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set URL
     *
     * @param  string $url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;

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
            'creator',
            'title',
            'image',
            'url',
        ]));

        return Builder::html($attributes);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check creator
     *
     * @param string $creator
     */
    private function checkCreator(&$creator)
    {
        if ( ! empty($creator) && ! starts_with($creator, '@')) {
            $creator = '@' . $creator;
        }
    }
}
