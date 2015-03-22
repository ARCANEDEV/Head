<?php namespace Arcanedev\Head\Contracts;

interface Versionable
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    public function getVersion();

    public function setVersion($version);
}
