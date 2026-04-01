<?php
namespace MarcoConsiglio\Goniometry\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\IntRange;
use MarcoConsiglio\Goniometry\Degrees;

class DegreesRange extends IntRange
{
    /**
     * The maximum number allowed.
     * 
     * @var int MAX
     */
    public const int MAX = Degrees::MAX - 1;

    /**
     * The minimum number allowed.
     * 
     * @var int MIN
     */
    public const int MIN = 0;
}