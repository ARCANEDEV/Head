<?php namespace Arcanedev\Head\Entities\OpenGraph\Objects;

use DateTime;

/**
 * Class BookObject
 * @package Arcanedev\Head\Entities\OpenGraph\Objects
 */
class BookObject extends AbstractObject
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
    const PREFIX    = 'book';

    /**
     * prefix namespace
     *
     * @var string
     */
    const NS        = 'http://ogp.me/ns/book#';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Book authors as an array of URIs.
     * The target URI is expected to have an Open Graph protocol type of 'profile'
     *
     * @var array
     */
    protected $author;

    /**
     * International Standard Book Number. ISBN-10 and ISBN-13 accepted
     * @link http://en.wikipedia.org/wiki/International_Standard_Book_Number ISBN
     *
     * @var string
     */
    protected $isbn;

    /**
     * The date the book was released, or planned release if in future.
     * Stored as an ISO 8601 date string normalized to UTC for consistency
     *
     * @var string
     */
    protected $release_date;

    /**
     * Tag words describing book content and subjects
     *
     * @var array
     */
    protected $tag;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
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
     * Book author URIs
     *
     * @return array author URIs
     */
    public function getAuthors()
    {
        return $this->author;
    }

    /**
     * Add an author URI.
     *
     * @param string $author_uri
     *
     * @return BookObject
     */
    public function addAuthor( $author_uri )
    {
        if (self::isValidUrl($author_uri) and ! in_array($author_uri, $this->author)) {
            $this->author[] = $author_uri;
        }

        return $this;
    }

    /**
     * International Standard Book Number
     *
     * @return string
     */
    public function getISBN()
    {
        return $this->isbn;
    }

    /**
     * Set an International Standard Book Number
     *
     * @param string $isbn
     *
     * @return BookObject
     */
    public function setISBN( $isbn )
    {
        $this->isbn = $this->prepareISBN($isbn);

        return $this;
    }

    /**
     * Book release date
     *
     * @return string - release date in ISO 8601 format
     */
    public function getReleaseDate()
    {
        return $this->release_date;
    }

    /**
     * Set the book release date
     *
     * @param DateTime|string $release_date release date as DateTime or as an ISO 8601 formatted string
     *
     * @return $this
     */
    public function setReleaseDate( $release_date )
    {
        if ($release_date instanceof DateTime) {
            $this->release_date = self::datetimeToIso8601($release_date);
        }

        // at least YYYY-MM-DD
        if (is_string($release_date) and strlen($release_date) >= 10) {
            $this->release_date = $release_date;
        }

        return $this;
    }
    /**
     * Book subject tags
     *
     * @return array Topic tags
     */
    public function getTags()
    {
        return $this->tag;
    }

    /**
     * Add a book topic tag
     *
     * @param string $tag topic tag
     *
     * @return BookObject
     */
    public function addTag( $tag )
    {
        if (
            is_string($tag) and
            ! empty($tag) and
            ! in_array($tag, $this->tag)
        ) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Published after 2007
     *
     * @param string $isbn
     *
     * @return bool
     */
    private function isNewISBNVersion($isbn)
    {
        return $this->checkISBNVersion($isbn, 10);
    }

    /**
     * Published before 2007
     *
     * @param string $isbn
     *
     * @return bool
     */
    private function isOldISBNVersion($isbn)
    {
        return $this->checkISBNVersion($isbn, 13);
    }

    /**
     * @param string $isbn
     * @param int    $lenght
     *
     * @return bool
     */
    private function checkISBNVersion($isbn, $lenght)
    {
        return strlen($isbn) === $lenght and is_numeric(substr($isbn, 0, $lenght - 1));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param $isbn
     *
     * @return string|null
     */
    private function prepareISBN($isbn)
    {
        if ( ! is_string($isbn)) {
            return null;
        }

        $isbn = trim(str_replace('-', '', $isbn));

        if ( $this->isOldISBNVersion($isbn) ) {
            $verifySum  = 0;
            $chars      = str_split($isbn);

            for ($i = 0; $i < 9; $i++) {
                $verifySum += ((int) $chars[$i]) * (10 - $i);
            }

            $checkDigit = 11 - ($verifySum % 11);

            if ( $checkDigit == $chars[9] or ($chars[9] == 'X' and $checkDigit == 10) ) {
                return $isbn;
            }
        }
        elseif ( $this->isNewISBNVersion($isbn) ) {
            $verifySum  = 0;
            $chars      = str_split($isbn);

            for ($i = 0; $i < 12; $i++) {
                $verifySum += ((int) $chars[$i]) * ((($i % 2) === 0) ? 1 : 3);
            }

            $checkDigit = 10 - ($verifySum % 10);

            if ( $checkDigit == $chars[12] ) {
                return $isbn;
            }
        }

        return null;
    }
}
