<?php namespace Arcanedev\Head\Entities\TwitterCard\Cards;

use Arcanedev\Head\Entities\TwitterCard\TwitterMetaBuilder as Builder;

/**
 * Class Gallery
 * @package Arcanedev\Head\Entities\TwitterCard\Cards
 *
 * @link https://dev.twitter.com/cards/types/gallery
 */
class Gallery extends AbstractCard
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
    protected $card = 'gallery';

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
     * @var string
     */
    protected $url = '';

    /**
     * @var string
     */
    protected $image0 = '';

    /**
     * @var string
     */
    protected $image1 = '';

    /**
     * @var string
     */
    protected $image2 = '';

    /**
     * @var string
     */
    protected $image3 = '';

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
     * Get Url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set Url
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

    /**
     * Get Image 0
     *
     * @return string
     */
    public function getImage0()
    {
        return $this->image0;
    }

    /**
     * Set Image 0
     *
     * @param string $image0
     *
     * @return self
     */
    public function setImage0($image0)
    {
        $this->image0 = $image0;

        return $this;
    }

    /**
     * Get Image 1
     *
     * @return string
     */
    public function getImage1()
    {
        return $this->image1;
    }

    /**
     * Set Image 1
     *
     * @param  string $image1
     *
     * @return self
     */
    public function setImage1($image1)
    {
        $this->image1 = $image1;

        return $this;
    }

    /**
     * Get Image 2
     *
     * @return string
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * Set Image 2
     *
     * @param  string $image2
     *
     * @return self
     */
    public function setImage2($image2)
    {
        $this->image2 = $image2;

        return $this;
    }

    /**
     * Get Image 3
     *
     * @return string
     */
    public function getImage3()
    {
        return $this->image3;
    }

    /**
     * Set Image 3
     *
     * @param  string $image3
     *
     * @return self
     */
    public function setImage3($image3)
    {
        $this->image3 = $image3;

        return $this;
    }

    /**
     * Get images
     *
     * @return array
     */
    public function getImages()
    {
        return array_filter([
            $this->getImage0(),
            $this->getImage1(),
            $this->getImage2(),
            $this->getImage3(),
        ]);
    }

    /**
     * Set multiple images - 4 images max
     *
     * @param  array $images
     *
     * @return self
     */
    public function setImages(array $images)
    {
        $images = array_slice($images, 0, 4);

        foreach($images as $key => $image) {
            $this->{'setImage' . $key}($image);
        }

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
            'description',
            'url',
            'image0',
            'image1',
            'image2',
            'image3',
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

    /**
     * Check description
     *
     * @param string $description
     */
    private function checkDescription(&$description)
    {
        $description = $this->truncate($description, 200);
    }
}
