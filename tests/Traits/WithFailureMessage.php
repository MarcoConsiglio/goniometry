<?php
namespace MarcoConsiglio\Goniometry\Tests\Traits;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
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
     */
    protected function getterFail(string $property): string
    {
        return "'$property' property is not working properly.";
    }

    /**
     * Return a function failure message.
     */
    protected function methodFail(string $name): string
    {
        return "'$name()' method is not working properly.";
    }

    /**
     * Return an instance type failure message.
     */
    protected static function instanceTypeFail(string $expected_class, string $actual_class): string
    {
        return "Expected $expected_class class but found $actual_class class instead.";
    }

    /**
     * Return a failure message when calling `$called_class::$method` doesn't return
     * the expected `$return_type`.
     */
    protected static function methodMustReturn(string $called_class, string $method, string $return_type): string
    {
        return "Calling $called_class::$method() must return a $return_type instance.";
    }

    /**
     * Produce a casting error message.
     *
     * @param string $type Type to cast to.
     */
    protected function getCastError(string $type): string
    {
        return "Something is not working when casting to $type.";
    }

    /**
     * Produce a property error message.
     */
    protected function getPropertyError(string $property_name): string
    {
        return "Angle::\${$property_name} property is not working correctly.";
    }

    /**
     * Return a comparison fail message.
     */
    protected function comparisonFail(
        AngularMeasure $alfa, 
        string $comparison, 
        int|float|string|AngularMeasure $beta
    ): string {
        $this->checkComparison($comparison);
        if (is_int($beta)) return "$alfa $comparison {$beta}°";
        if (is_float($beta))
            return "{$alfa->toSexadecimalDegrees()} $comparison {$beta}°";
        return "$alfa $comparison $beta";
    }

    protected function comparisonWithDeltaFail(
        AngularMeasure $alfa,
        string $comparison,
        int|float|string|AngularMeasure $beta,
        Angle $delta
    ): string {
        $error = $delta->toFloat() / 2;
        if (is_int($beta)) return "$alfa $comparison {$beta}° with error ±{$error}°";
        if (is_float($beta))
            return "{$alfa->toSexadecimalDegrees()} $comparison {$beta}°  with error ±{$error}°";
        return "$alfa $comparison $beta  with error ±{$error}°";
    }

    /**
     * Return a fuzzy comparison fail message.
     */
    protected function fuzzyComparisonFail(
        AngularMeasure $alfa, 
        string $comparison,
        AngularMeasure $beta,
        AngularMeasure $delta
    ): string {
        $this->checkComparison($comparison);
        return "{$alfa->toSexadecimalDegrees()} $comparison {$beta->toSexadecimalDegrees()} with delta {$delta->toSexadecimalDegrees()}.";
    }

    /**
     * Check if `$comparison` is allowed.
     */
    protected function checkComparison(string $comparison): void
    {
        if (! in_array($comparison, $this->allowed_comparisons))
            throw new ValueError("\"$comparison\" is not an allowed comparison.");
    }

    /**
     * Return a sexagesimal fail error.
     */
    protected function sexagesimalFail(
        SexagesimalDegrees $expected, 
        SexagesimalDegrees $actual
    ): string {
        return "{$expected} ≠ {$actual}"; 
    }
}