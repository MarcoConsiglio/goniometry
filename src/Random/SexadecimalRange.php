<?php
namespace MarcoConsiglio\Goniometry\Random;

use Deprecated;
use MarcoConsiglio\FakerPhpNumberHelpers\FloatRange;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Seconds;

class SexadecimalRange extends FloatRange
{
    /**
     * The maximum number allowed.
     * 
     * @var float MAX
     */
    #[Deprecated("use max() method instead")]
    public const float MAX = PHP_FLOAT_MAX;

    /**
     * The minimum number allowed.
     * 
     * @var float MIN
     */
    #[Deprecated("use min() method instead")]
    public const float MIN = 0.0;

    public static function max(): float
    {
        return NextFloat::before(Seconds::MAX);
    }

    public static function min(): float
    {
        return NextFloat::after(-Seconds::MAX);
    }
}