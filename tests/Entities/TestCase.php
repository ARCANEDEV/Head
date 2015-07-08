<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Tests\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @package Arcanedev\Head\Tests\Entities
 */
abstract class TestCase extends BaseTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Helper Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param string $class
     * @param string $method
     *
     * @return \ReflectionMethod
     */
    protected static function getMethod($class, $method)
    {
        return parent::getMethod('Entities\\' . $class, $method);
    }
}
