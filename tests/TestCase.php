<?php namespace Arcanedev\Head\Tests;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    const BASE_NAMESPACE = 'Arcanedev\\Head\\';

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
        $class = new ReflectionClass(self::BASE_NAMESPACE . $class);

        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method;
    }
}
