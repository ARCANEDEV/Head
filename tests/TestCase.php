<?php namespace Arcanedev\Head\Tests;

use ReflectionClass;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Dummy Function
     | ------------------------------------------------------------------------------------------------
     */
    const BASE_NAMESPACE = 'Arcanedev\\Head\\';

    public function testDummy()
    {
        $this->assertTrue(true);
    }

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
