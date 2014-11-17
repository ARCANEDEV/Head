<?php namespace Arcanedev\Head\Contracts;

interface TitleInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @return string
     */
    public function get();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     *
     * @return TitleInterface
     */
    public function set($title);

    /**
     * @param string $siteName
     *
     * @return TitleInterface
     */
    public function siteName($siteName = '');

    public function hideSiteName();

    public function showSiteName();

    public function siteNameFirst();

    public function siteNameLast();

    public function separator($separator = '|');
}
