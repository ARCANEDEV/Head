<?php namespace Arcanedev\Head\Entities\TwitterCard\Cards;

use Arcanedev\Head\Entities\TwitterCard\TwitterMetaBuilder as Builder;

/**
 * Class Product
 * @package Arcanedev\Head\Entities\TwitterCard\Cards
 *
 * @link https://dev.twitter.com/cards/types/product
 */
class Product extends AbstractCard
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
    protected $card = 'product';

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
     * This field expects a string, and you can specify values for labels such as
     * price, items in stock, sizes, etc
     * @var string
     */
    protected $data1 = '';

    /**
     * This field also expects a string, and allows you to specify the types of
     * data you want to offer (price, country, etc.)
     *
     * @var string
     */
    protected $label1 = '';

    /**
     * This field expects a string, and you can specify values for labels such as price,
     * items in stock, sizes, etc
     *
     * @var string
     */
    protected $data2 = '';

    /**
     * This field also expects a string, and allows you to specify the types of data you
     * want to offer (price, country, etc.)
     *
     * @var string
     */
    protected $label2 = '';

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
        $this->checkImage($image);
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getData1()
    {
        return $this->data1;
    }

    /**
     * @param  string $data1
     *
     * @return self
     */
    public function setData1($data1)
    {
        $this->checkNotEmpty($data1, 'The product\'s data1 is required.');
        $this->data1 = $data1;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel1()
    {
        return $this->label1;
    }

    /**
     * @param  string $label1
     *
     * @return self
     */
    public function setLabel1($label1)
    {
        $this->checkNotEmpty($label1, 'The product\'s label1 is required.');
        $this->label1 = $label1;

        return $this;
    }

    /**
     * @return string
     */
    public function getData2()
    {
        return $this->data2;
    }

    /**
     * @param  string $data2
     *
     * @return self
     */
    public function setData2($data2)
    {
        $this->checkNotEmpty($data2, 'The product\'s data2 is required.');
        $this->data2 = $data2;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel2()
    {
        return $this->label2;
    }

    /**
     * @param  string $label2
     *
     * @return self
     */
    public function setLabel2($label2)
    {
        $this->checkNotEmpty($label2, 'The product\'s label2 is required.');
        $this->label2 = $label2;

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
            'image',
            'data1',
            'label1',
            'data2',
            'label2',
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
        return parent::isEmpty() || empty($this->title) || empty($this->description) || empty($this->image);
    }

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
        if (empty($description)) {
            throw new \InvalidArgumentException(
                'The description attribute must not be empty.'
            );
        }

        $description = $this->truncate($description, 200);
    }

    /**
     * Check image
     *
     * @param string $image
     */
    private function checkImage($image)
    {
        $this->checkNotEmpty($image, 'The product image is required.');
    }

    protected function checkNotEmpty($value, $message)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException($message);
        }
    }
}
