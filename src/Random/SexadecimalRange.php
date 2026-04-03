<?php
namespace MarcoConsiglio\Goniometry\Random;

use Deprecated;
use MarcoConsiglio\FakerPhpNumberHelpers\FloatRange;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Degrees;

class SexadecimalRange extends FloatRange
{
    /**
     * The maximum number allowed.
     * 
     * @var float MAX
     */
    #[Deprecated("use max() method instead")]
    public const float MAX = Degrees::MAX;

    /**
     * The minimum number allowed.
     * 
     * @var float MIN
     */
    #[Deprecated("use min() method instead")]
    public const float MIN = -Degrees::MAX;

    public static function max(): float
    {
        return NextFloat::before(Degrees::MAX);
    }

    public static function min(): float
    {
        return NextFloat::after(-Degrees::MAX);
    }
}