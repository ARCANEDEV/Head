<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Contracts\Entities\KeywordsInterface;
use Arcanedev\Head\Exceptions\InvalidTypeException;

class Keywords extends AbstractMeta implements KeywordsInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var array
     */
    protected $keywords;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    public function __construct()
    {
        $this->keywords = [];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Keywords
     *
     * @return array
     */
    public function get()
    {
        return $this->keywords;
    }

    /**
     * Set Keywords
     *
     * @param string|array $keywords
     *
     * @throws InvalidTypeException
     *
     * @return Keywords
     */
    public function set($keywords)
    {
        $this->checkType($keywords);

        if (is_string($keywords)) {
            $keywords = $this->convertStringToArray($keywords);
        }

        if (is_array($keywords)) {
            $this->setFromArray($keywords);
        }

        return $this;
    }

    /**
     * Set Keywords form array
     *
     * @param array $keywords
     *
     * @return Keywords
     */
    private function setFromArray(array $keywords = [])
    {
        $this->checkAllKeywords($keywords);

        $this->keywords = array_filter($keywords);

        return $this;
    }

    /**
     * Get SEO Keywords
     *
     * @return string
     */
    protected function getSEOKeywords()
    {
        // TODO: Optimize the keywords render
        return implode(', ', $this->keywords);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render Keywords tag
     *
     * @return string
     */
    public function render()
    {
        return ! $this->isEmpty()
            ? $this->renderMetaTag('keywords', $this->getSEOKeywords())
            : '';
    }

    /**
     * Get Keywords Count
     *
     * @return int
     */
    public function count()
    {
        return count($this->keywords);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if keywords is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->keywords);
    }

    /**
     * Check Keywords Type
     *
     * @param string|array $keywords
     *
     * @throws InvalidTypeException
     */
    private function checkType($keywords)
    {
        if (
            ! is_string($keywords) and
            ! is_array($keywords)
        ) {
            throw new InvalidTypeException('keywords', $keywords, 'string or array');
        }
    }

    /**
     * Check all keywords are strings
     *
     * @param array $keywords
     *
     * @throws InvalidTypeException
     */
    private function checkAllKeywords($keywords)
    {
        foreach($keywords as $keyword) {
            if (is_string($keyword)) {
                continue;
            }

            throw new InvalidTypeException('keyword', $keyword);
        }
    }

    /**
     * Convert Keywords string to array
     *
     * @param string $keywords
     *
     * @return array
     */
    private function convertStringToArray($keywords)
    {
        $keywords = array_map('trim', explode(',', $keywords));

        return $keywords;
    }
}
