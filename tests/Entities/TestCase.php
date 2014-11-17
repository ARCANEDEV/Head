<?php namespace Arcanedev\Head\Tests\Entities;

use Arcanedev\Head\Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Dummy Function
     | ------------------------------------------------------------------------------------------------
     */
    public function testDummy()
    {
        parent::testDummy();
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
        return parent::getMethod('Entities\\' . $class, $method);
    }
}
