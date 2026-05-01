<?php
namespace MarcoConsiglio\Goniometry\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;

class AngularDistanceRange extends SexadecimalRange
{
    #[Override]
    public static function max(): float
    {
        return NextFloat::before(SexadecimalAngularDistance::MAX);
    }

    #[Override]    
    public static function min(): float
    {
        return NextFloat::after(SexadecimalAngularDistance::MIN);
    } 
}