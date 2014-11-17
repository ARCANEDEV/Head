<?php namespace Arcanedev\Head\Contracts;

interface VersionableInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    public function getVersion();

    public function setVersion($version);
}
