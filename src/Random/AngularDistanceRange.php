<?php
namespace MarcoConsiglio\Goniometry\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;

/**
 * The `AngularDistance` random range.
 */
class AngularDistanceRange extends SexadecimalRange
{
    /**
     * The maximum number allowed.
     */
    #[Override]
    public static function max(): float
    {
        return NextFloat::before(SexadecimalAngularDistance::MAX);
    }

    /**
     * The minimum number allowed.
     */
    #[Override]    
    public static function min(): float
    {
        return NextFloat::after(SexadecimalAngularDistance::MIN);
    } 
}