<?php namespace Arcanedev\Head\Entities\OpenGraph\Objects;

use DateTime;

/**
 * Class ArticleObject
 * @package Arcanedev\Head\Entities\OpenGraph\Objects
 */
class ArticleObject extends AbstractObject
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Property prefix
     *
     * @var string
     */
    const PREFIX = 'article';

    /**
     * prefix namespace
     *
     * @var string
     */
    const NS     = 'http://ogp.me/ns/article#';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * When the article was first published.
     * ISO 8601 formatted string.
     * @var string
     */
    protected $published_time;

    /**
     * When the article was last changed
     * ISO 8601 formatted string.
     * @var string
     */
    protected $modified_time;

    /**
     * When the article is considered out-of-date
     * ISO 8601 formatted string.
     * @var string
     */
    protected $expiration_time;

    /**
     * Writers of the article.
     * Array of author URIs
     * @var array
     */
    protected $author;

    /**
     * High-level section or category
     * @var string
     */
    protected $section;

    /**
     * Content tag
     * Array of tag strings
     * @var array
     */
    protected $tag;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Initialize arrays
     */
    public function __construct()
    {
        $this->author   = [];
        $this->tag      = [];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * When the article was first published
     * @return string ISO 8601 formatted publication date and optional time
     */
    public function getPublishedTime()
    {
        return $this->published_time;
    }

    /**
     * Set when the article was first published
     *
     * @param DateTime|string $pubdate - ISO 8601 formatted datetime string or DateTime object for conversion
     *
     * @return ArticleObject
     */
    public function setPublishedTime($pubdate)
    {
        if ($pubdate instanceof DateTime) {
            $this->published_time = self::datetimeToIso8601($pubdate);
        }

        // At least YYYY-MM-DD
        if (is_string($pubdate) and strlen($pubdate) >= 10) {
            $this->published_time = $pubdate;
        }

        return $this;
    }

    /**
     * When article was last changed
     *
     * @return string - ISO 8601 formatted modified date and optional time
     */
    public function getModifiedTime()
    {
        return $this->modified_time;
    }

    /**
     * Set when the article was last changed
     *
     * @param DateTime|string $updated - ISO 8601 formatted datetime string or DateTime object for conversion
     *
     * @return ArticleObject
     */
    public function setModifiedTime($updated)
    {
        if ( $updated instanceof DateTime ) {
            $this->modified_time = self::datetimeToIso8601($updated);
        }

        // At least YYYY-MM-DD
        if ( is_string($updated) and strlen($updated) >= 10 ) {
            $this->modified_time = $updated;
        }

        return $this;
    }
    /**
     * Time the article content expires
     *
     * @return string ISO 8601 formatted expiration date and optional time
     */
    public function getExpirationTime()
    {
        return $this->expiration_time;
    }

    /**
     * Set when the article content expires
     *
     * @param DateTime|string $expires - ISO formatted datetime string or DateTime object for conversion
     *
     * @return $this
     */
    public function setExpirationTime( $expires )
    {
        if ( $expires instanceof DateTime ) {
            $this->expiration_time = self::datetimeToIso8601($expires);
        }

        if ( is_string($expires) and strlen($expires) >= 10 ) {
            $this->expiration_time = $expires;
        }

        return $this;
    }

    /**
     * Article author URIs
     *
     * @return array Article author URIs
     */
    public function getAuthors()
    {
        return $this->author;
    }

    /**
     * Add an author URI
     *
     * @param string $author_uri - Author URI
     *
     * @return ArticleObject
     */
    public function addAuthor( $author_uri )
    {
        if (self::isValidUrl($author_uri) and ! in_array($author_uri, $this->author)) {
            $this->author[] = $author_uri;
        }

        return $this;
    }

    /**
     * High-level section name
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set the top-level content section
     *
     * @param string $section
     *
     * @return ArticleObject
     */
    public function setSection( $section )
    {
        if (is_string($section) and ! empty($section)) {
            $this->section = $section;
        }

        return $this;
    }

    /**
     * Content tags
     * @return array content tags
     */
    public function getTags()
    {
        return $this->tag;
    }

    /**
     * Add a content tag
     *
     * @param string $tag content tag
     *
     * @return ArticleObject
     */
    public function addTag( $tag ) {
        if (is_string($tag) and ! empty($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }
}
