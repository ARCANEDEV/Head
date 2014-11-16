<?php namespace Arcanedev\Head\Entities;

use Arcanedev\Head\Exceptions\InvalidTypeException;

class Keywords extends AbstractMeta
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var array
     */
    protected $keywords = [];

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
    public function get()
    {
        return $this->keywords;
    }

    public function set($keywords)
    {
        if ( ! is_string($keywords) and ! is_array($keywords) ) {
            throw new InvalidTypeException('keywords', $keywords, 'string or array');
        }

        if ( is_string($keywords) ) {
            $keywords = array_map(function($keyword) {
                return trim($keyword);
            }, explode(',', $keywords));
        }

        if ( is_array($keywords) ) {
            $this->setFromArray($keywords);
        }
    }

    /**
     * @param array $keywords
     */
    private function setFromArray(array $keywords = [])
    {
        $this->checkAllKeywords($keywords);

        $this->keywords = array_filter($keywords);
    }

    protected function getSEOKeywords()
    {
        return implode(', ', $this->keywords);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function render()
    {
        return parent::renderMetaTag('keywords', $this->getSEOKeywords());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    private function checkAllKeywords($keywords)
    {
        foreach($keywords as $keyword) {
            if ( ! is_string($keyword) )
                throw new InvalidTypeException('keyword', $keyword);
        }
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->keywords);
    }
}
