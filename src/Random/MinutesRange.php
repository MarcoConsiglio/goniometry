<?php
namespace MarcoConsiglio\Goniometry\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\IntRange;
use MarcoConsiglio\Goniometry\Minutes;

/**
 * The `Minutes` random range.
 */
class MinutesRange extends IntRange
{
    /**
     * The maximum number allowed.
     * 
     * @var int MAX
     */
    public const int MAX = Minutes::MAX - 1;

    /**
     * The minimum number allowed.
     * 
     * @var int MIN
     */
    public const int MIN = 0;
}