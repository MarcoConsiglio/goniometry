<?php
namespace MarcoConsiglio\Goniometry\Tests\Traits;

/**
 * Provides testing failure message helpers.
 */
trait WithFailureMessage
{
    /**
     * Gets a property type failure message.
     *
     * @param string $property
     * @return string
     */
    protected function typeFail(string $property): string
    {
        return "'$property' type not expected.";
    }

    /**
     * Gets a getter failure message.
     *
     * @param string $property
     * @return string
     */
    protected function getterFail(string $property): string
    {
        return "'$property' property is not working properly.";
    }

    /**
     * Gets a function failure message.
     *
     * @param string $name
     * @return string
     */
    protected function methodFail(string $name): string
    {
        return "'$name()' method is not working properly.";
    }

    /**
     * Get an instance type failure message.
     *
     * @param [type] $expected_class
     * @param [type] $actual_class
     * @return string
     */
    protected static function instanceTypeFail($expected_class, $actual_class): string
    {
        return "Expected $expected_class class but found $actual_class class instead.";
    }

    /**
     * Produces a failure message when calling $called_class::$method doesn't return
     * the expected $return_type.
     *
     * @param string $called_class
     * @param string $method
     * @param string $return_type
     * @return string
     */
    protected static function methodMustReturn(string $called_class, string $method, string $return_type): string
    {
        return "Calling $called_class::$method() must return a $return_type instance.";
    }
}