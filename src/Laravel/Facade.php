<?php namespace Arcanedev\Head\Laravel;
use Illuminate\Support\Facades\Facade as IlluminateFacade;

/**
 * Class Facade
 * @package Arcanedev\Head\Laravel
 */
class Facade extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'arcanedev.head'; }
}
