<?php namespace Arcanedev\Head\Contracts;

use Arcanedev\Head\Contracts\Entities\CharsetInterface;
use Arcanedev\Head\Contracts\Entities\MetaInterface;
use Arcanedev\Head\Entities\Meta;

use Arcanedev\Head\Contracts\Entities\DescriptionInterface;
use Arcanedev\Head\Contracts\Entities\KeywordsInterface;
use Arcanedev\Head\Contracts\Entities\MetaCollectionInterface;
use Arcanedev\Head\Contracts\Entities\TitleInterface;

use Arcanedev\Head\Entities\MetaCollection;
use Arcanedev\Head\Entities\OpenGraph\OpenGraph;
use Arcanedev\Head\Exceptions\InvalidTypeException;

interface HeadInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Charset
     *
     * @return CharsetInterface
     */
    public function charset();

    /**
     * Set Charset
     *
     * @param CharsetInterface|string $charset
     *
     * @return HeadInterface
     */
    public function setCharset($charset);

    /**
     * Set SEO Tags
     *
     * @param string       $title
     * @param string       $description
     * @param array|string $keywords
     *
     * @throws InvalidTypeException
     *
     * @return HeadInterface
     */
    public function set($title, $description, $keywords = []);

    /**
     * Get the Title
     *
     * @return string
     */
    public function getTitle();

    /**
     * @param TitleInterface|string $title
     *
     * @throws InvalidTypeException
     *
     * @return HeadInterface
     */
    public function setTitle($title);

    /**
     * Get the description
     *
     * @return DescriptionInterface
     */
    public function description();

    /**
     * @param DescriptionInterface|string $description
     *
     * @throws InvalidTypeException
     *
     * @return HeadInterface
     */
    public function setDescription($description);

    /**
     * Get Keywords
     *
     * @return KeywordsInterface
     */
    public function keywords();

    /**
     * Set Keywords
     *
     * @param KeywordsInterface|string $keywords
     *
     * @throws InvalidTypeException
     *
     * @return HeadInterface
     */
    public function setKeywords($keywords);

    /**
     * Get Meta Collection
     *
     * @return MetaCollection
     */
    public function metas();

    /**
     * Add Meta
     *
     * @param string $name
     * @param string $content
     * @param array  $attributes
     *
     * @return HeadInterface
     */
    public function addMeta($name, $content, $attributes = []);

    /**
     * Set Meta
     *
     * @param MetaInterface $meta
     *
     * @return HeadInterface
     */
    public function setMeta(MetaInterface $meta);

    /* ------------------------------------------------------------------------------------------------
     |  Facebook / OpenGraph Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get OpenGraph
     *
     * @return OpenGraph
     */
    public function openGraph();

    /**
     * Enable OpenGraph
     *
     * @return HeadInterface
     */
    public function doFacebook();

    /**
     * Disable OpenGraph
     *
     * @return HeadInterface
     */
    public function noFacebook();

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render Head Tags
     *
     * @return string
     */
    public function render();

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if OpenGraph Enabled
     *
     * @return bool
     */
    public function isOpenGraphEnabled();
}
