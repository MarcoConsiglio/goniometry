<?php
namespace MarcoConsiglio\Goniometry\Tests\Traits;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use ValueError;

/**
 * Provides testing failure message helpers.
 */
trait WithFailureMessage
{
    private array $allowed_comparisons = [
        '<', '≤', '=', '≅', '≠', '>', '≥'
    ];

    /**
     * Return a property type failure message.
     *
     * @param string $property
     * @return string
     */
    protected function typeFail(string $property): string
    {
        return "'$property' type not expected.";
    }

    /**
     * Return a property failure message.
     * 
     * @param string $property The property name.
     */
    protected function propertyFail(string $property): string
    {
        return "{$property} property is not working properly.";
    }

    /**
     * Return a getter failure message.
     *
     * @param string $property
     * @return string
     */
    protected function getterFail(string $property): string
    {
        return "'$property' property is not working properly.";
    }

    /**
     * Return a function failure message.
     *
     * @param string $name
     * @return string
     */
    protected function methodFail(string $name): string
    {
        return "'$name()' method is not working properly.";
    }

    /**
     * Return an instance type failure message.
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
     * Return a failure message when calling $called_class::$method doesn't return
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

    /**
     * It produces a casting error message.
     *
     * @param string $type Type to cast to.
     * @return string
     */
    protected function getCastError(string $type): string
    {
        return "Something is not working when casting to $type.";
    }

    /**
     * It produces a property error message.
     *
     * @param string $property_name
     * @return string
     */
    protected function getPropertyError(string $property_name): string
    {
        return "Angle::\${$property_name} property is not working correctly.";
    }

    /**
     * Return a comparison fail message.
     */
    protected function comparisonFail(
        Angle $alfa, 
        string $comparison, 
        int|float|string|Angle $beta
    ): string {
        $this->checkComparison($comparison);
        if (is_int($beta)) return "$alfa $comparison {$beta}°";
        if (is_float($beta)) { 
            $float = new Number($beta)->value;
            return "{$alfa->toSexadecimalDegrees()} $comparison {$float}°";
        }
        return "$alfa $comparison $beta";
    }

    /**
     * Return a fuzzy comparison fail message.
     */
    protected function fuzzyComparisonFail(
        Angle $alfa, 
        string $comparison,
        Angle $beta,
        Angle $delta
    ): string {
        $this->checkComparison($comparison);
        return "{$alfa->toSexadecimalDegrees()} $comparison {$beta->toSexadecimalDegrees()} with delta {$delta->toSexadecimalDegrees()}.";
    }

    protected function checkComparison(string $comparison): void
    {
        if (! in_array($comparison, $this->allowed_comparisons))
            throw new ValueError("\"$comparison\" is not an allowed comparison.");
    }
}