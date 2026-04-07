<?php
namespace MarcoConsiglio\Goniometry\Random;

use Deprecated;
use MarcoConsiglio\FakerPhpNumberHelpers\FloatRange;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Radian;

/**
 * The `Radian` random range.
 */
class RadianRange extends FloatRange
{
    /**
     * The maximum number allowed.
     * 
     * @var float MAX
     */
    #[Deprecated("use max() method instead")]
    public const float MAX = Radian::MAX;

    /**
     * The minimum number allowed.
     * 
     * @var float MIN
     */
    #[Deprecated("use min() method instead")]
    public const float MIN = -Radian::MAX;

    public static function max(): float
    {
        return NextFloat::before(Radian::MAX);
    }

    public static function min(): float
    {
        return NextFloat::after(-Radian::MAX);
    }
}