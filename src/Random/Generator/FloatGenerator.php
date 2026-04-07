<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator as RandomGenerator;

abstract class FloatGenerator extends RandomGenerator
{
    /**
     * Limit the `$precision` between `0` and `PHP_FLOAT_DIG`.
     */
    protected function normalizePrecision(int $precision): int
    {
        $precision = abs($precision);
        if ($precision > PHP_FLOAT_DIG) $precision = PHP_FLOAT_DIG;
        return $precision;       
    }
}