<?php
namespace MarcoConsiglio\Goniometry\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\IntRange;
use MarcoConsiglio\Goniometry\Degrees;

/**
 * The `Degrees` random range.
 * 
 * @internal
 */
class DegreesRange extends IntRange
{
    /**
     * The maximum number allowed.
     */
    public const int MAX = Degrees::MAX - 1;

    /**
     * The minimum number allowed.
     */
    public const int MIN = 0;
}