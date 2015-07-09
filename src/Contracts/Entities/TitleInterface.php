<?php namespace Arcanedev\Head\Contracts\Entities;

use Arcanedev\Head\Exceptions\EmptyTitleException;
use Arcanedev\Head\Exceptions\InvalidTypeException;

/**
 * Interface TitleInterface
 * @package Arcanedev\Head\Contracts\Entities
 */
interface TitleInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get Title
     *
     * @return string
     */
    public function get();

    /**
     * Get Title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set Title
     *
     * @param string $title
     *
     * @throws InvalidTypeException
     * @throws EmptyTitleException
     *
     * @return TitleInterface
     */
    public function set($title);

    /**
     * Set or Get Site Name
     *
     * @param string $siteName
     *
     * @throws InvalidTypeException
     *
     * @return TitleInterface|string
     */
    public function siteName($siteName = '');

    /**
     * Set Site Name
     * @param string $siteName
     *
     * @throws InvalidTypeException
     *
     * @return TitleInterface
     */
    public function setSiteName($siteName);

    /**
     * Get Site Name
     *
     * @return string
     */
    public function getSiteName();

    /**
     * Hide Site Name
     *
     * @return TitleInterface
     */
    public function hideSiteName();

    /**
     * Show Site Name
     *
     * @return TitleInterface
     */
    public function showSiteName();

    /**
     * Set Site name first
     *
     * @return TitleInterface
     */
    public function siteNameFirst();

    /**
     * Set Site Name last
     *
     * @return TitleInterface
     */
    public function siteNameLast();

    /**
     * Set or Get Separator
     *
     * @param string $separator
     *
     * @throws InvalidTypeException
     *
     * @return TitleInterface|string
     */
    public function separator($separator = '');

    /**
     * Get Separator
     *
     * @return string
     */
    public function getSeparator();

    /**
     * @param string $separator
     *
     * @throws InvalidTypeException
     *
     * @return TitleInterface
     */
    public function setSeparator($separator = '|');

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Render Title tag
     *
     * @return string
     */
    public function render();

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if Title is empty
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Check if Site Name is empty
     *
     * @return bool
     */
    public function isSiteNameEmpty();

    /**
     * Check if Site Name is visible
     *
     * @return bool
     */
    public function isSiteNameVisible();

    /**
     * Check if Site Name is hidden
     *
     * @return bool
     */
    public function isSiteNameHidden();

    /**
     * Check if Site Name is First
     *
     * @return bool
     */
    public function isSiteNameFirst();
}
