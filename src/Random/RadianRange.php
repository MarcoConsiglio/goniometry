<?php
namespace MarcoConsiglio\Goniometry\Random;

use Deprecated;
use MarcoConsiglio\FakerPhpNumberHelpers\FloatRange;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\RadianAngle;

/**
 * The `RadianAngle` random range.
 * 
 * @internal
 */
class RadianRange extends FloatRange
{
    /**
     * The maximum number allowed.
     * 
     * @var float MAX
     */
    #[Deprecated("use max() method instead")]
    public const float MAX = RadianAngle::MAX;

    /**
     * The minimum number allowed.
     * 
     * @var float MIN
     */
    #[Deprecated("use min() method instead")]
    public const float MIN = -RadianAngle::MAX;

    /**
     * The maximum number allowed.
     */
    public static function max(): float
    {
        return NextFloat::before(RadianAngle::MAX);
    }

    /**
     * The minimum number allowed.
     */
    public static function min(): float
    {
        return NextFloat::after(RadianAngle::MIN);
    }
}