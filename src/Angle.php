<?php declare(strict_types=1);
namespace MarcoConsiglio\Goniometry;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Builders\FromAnglesToAbsoluteSum;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Exceptions\RegExFailureException;
use MarcoConsiglio\Goniometry\Builders\FromAnglesToRelativeSum;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use MarcoConsiglio\Goniometry\Interfaces\AngleBuilder;
use Marcoconsiglio\ModularArithmetic\ModularNumber;
use RoundingMode;

/**
 * Represents an angle.
 */
class Angle implements AngleInterface
{
    /**
     * Regular expression used to parse degrees value as integer number.
     * 
     * @var string
     */
    public const DEGREES_REGEX = "/(?<!\d)(-?(?:360|3[0-5]\d|[12]?\d{1,2}))°/";

    /**
     * Regular expression used to parse minutes value as integer number.
     * 
     * @var string
     */
    public const MINUTES_REGEX = '/\b([0-5]?\d)\'/';

    /**
     * Regular expression used to parse second value as decimal number.
     * 
     * @var string
     */
    public const SECONDS_REGEX = '/\b((?:[1-5]?\d)(?:\.\d+)?)"/';
   
    /**
     * It represents a negative angle.
     * 
     * @var int
     */
    public const CLOCKWISE = -1;

    /**
     * It represents a positive angle.
     * 
     * @var int
     */
    public const COUNTER_CLOCKWISE = 1;

    /**
     * The max degrees an angle can have.
     * 
     * @var int
     */
    public const MAX_DEGREES = 360;

    /**
     * The max minutes an angle can have.
     * 
     * @var int
     */
    public const MAX_MINUTES = 60;

    /**
     * The max seconds an angle can have.
     * 
     * @var int
     */
    public const MAX_SECONDS = 60;

    /**
     * Radian measure of a round angle.
     * 
     * @var float
     */
    public const MAX_RADIAN = 2 * M_PI;

    /**
     * The degrees part.
     */
    public protected(set) Degrees $degrees;

    /**
     * The minutes part.
     */
    public protected(set) Minutes $minutes;

    /**
     * The seconds part.
     */
    public protected(set) Seconds $seconds;

    /** 
     * The original decimal degrees if the `Angle` is built with
     * a `FromDecimal` builder.
     * 
     * It is used to cast faster the `Angle` to decimal.
     * 
     * @var float|null
     */
    protected float|null $original_decimal = null;

    /** 
     * The original radian degrees if the `Angle` is built with
     * a `FromRadian` builder.
     * 
     * It is used cast faster the `Angle` to radian.
     * 
     * @var float|null
     */
    protected float|null $original_radian = null;

    /** 
     * The angle direction.
     */
    public protected(set) Direction $direction = Direction::COUNTER_CLOCKWISE;

    /**
     * Construct an `Angle`.
     *
     * @param AngleBuilder $builder The builder used to construct the angle.
     * @return void
     */
    public function __construct(AngleBuilder $builder)
    {
        [
            $this->degrees, 
            $this->minutes, 
            $this->seconds, 
            $this->direction,
            $this->original_decimal,
            $this->original_radian
        ] = $builder->fetchData();
    }

    /**
     * Creates an angle from its values.
     *
     * @param integer $degrees
     * @param integer $minutes
     * @param float $seconds
     * @return Angle
     */
    public static function createFromValues(int $degrees = 0, int $minutes = 0, float $seconds = 0.0, Direction $direction = Direction::COUNTER_CLOCKWISE): Angle
    {
        return new Angle(new FromDegrees($degrees, $minutes, $seconds, $direction));
    }

    /**
     * Creates an angle from its textual representation.
     *
     * @param string $angle
     * @return Angle
     * @throws NoMatchException when $angle has no match.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public static function createFromString(string $angle): Angle
    {
        return new Angle(new FromString($angle));
    }

    /**
     * Creates an angle from its decimal representation.
     *
     * @param float $decimal_degrees
     * @return Angle
     * @throws AngleOverflowException when creating an angle greater than +/-360°.
     */
    public static function createFromDecimal(float $decimal_degrees): Angle
    {
        return new Angle(new FromDecimal($decimal_degrees));
    }

    /**
     * Creates an angle from its radian representation.
     *
     * @param float $radian
     * @return Angle
     * @throws AngleOverflowException when creating an angle greater than +/-360°.
     */
    public static function createFromRadian(float $radian): Angle
    {
         return new Angle(new FromRadian($radian));
    }

    /**
     * Sums two relative angles.
     * 
     * The result can be positive or negative.
     *
     * @param AngleInterface $first_angle
     * @param AngleInterface $second_angle
     * @return Angle
     */
    public static function sum(AngleInterface $first_angle, AngleInterface $second_angle): Angle
    {
        return new Angle(new FromAnglesToRelativeSum($first_angle, $second_angle));
    }

    /**
     * Sums two absolute angles.
     * 
     * The result can be only positive even if its inputs are negative angles,
     * beacause they are treated as absolute angles.
     */
    public static function absSum(AngleInterface $first_angle, AngleInterface $second_angle): Angle
    {
        return new Angle(new FromAnglesToAbsoluteSum($first_angle, $second_angle));
    }

    /**
     * Return an array containing the values
     * of "degrees", "minutes" and "seconds".
     * 
     * The sign/direction of the angle is in the
     * degrees value.
     *
     * @param bool $associative Set to true it returns an associative array.
     * @return array{int,int,float}|array{degrees:int,minutes:int,seconds:float}
     */
    public function getDegrees(bool $associative = false): array
    {
        $degrees = (int) $this->degrees->value->mul($this->direction->value)->value;
        $minutes = (int) $this->minutes->value->value;
        $seconds = round((float) $this->seconds->value->value, PHP_FLOAT_DIG, RoundingMode::HalfTowardsZero);
        if ($associative)
            return [
                "degrees" => $degrees,
                "minutes" => $minutes,
                "seconds" => $seconds
            ];
        else
            return [$degrees, $minutes, $seconds];
    }

    /**
     * Check if this angle is clockwise or negative.
     *
     * @return boolean
     */
    public function isClockwise(): bool
    {
        return $this->direction == Direction::CLOCKWISE;
    }

    /**
     * Check if this angle is counterclockwise or positive.
     *
     * @return boolean
     */
    public function isCounterClockwise(): bool
    {
        return $this->direction == Direction::COUNTER_CLOCKWISE;
    }

    /**
     * Reverse the direction of the rotation.
     *
     * @return Angle A new instance with the opposite
     */
    public function toggleDirection(): Angle
    {
        $clone = clone $this;
        $clone->direction =
            $clone->direction === Direction::COUNTER_CLOCKWISE ?
            Direction::CLOCKWISE :
            Direction::COUNTER_CLOCKWISE;
        return $clone;
    }

    /**
     * Return the sexadecimal value of this `Angle`.
     *
     * @param integer|null $precision The number of decimal digits. If sets to null,
     * it resolve the original precision at the time this Angle was built.
     * @return float The angular value expressed as a decimal number.
     */
    public function toFloat(int|null $precision = null): float
    {
        if ($this->original_decimal !== null)
            return new Round($this->original_decimal, $precision)->cast();
        return new Cast(
            $this->degrees, 
            $this->minutes,
            $this->seconds,
            $this->direction,
            $precision
        )->cast();
    }

    /**
     * Return the sexadecimal value of this `Angle` with an arbitrary 
     * precision.
     */
    public function toDecimal(): Number
    {
        if ($this->original_decimal !== null)
            return new Number($this->original_decimal);
        $decimal = $this->degrees->value->plus(
            $this->minutes->value->div(Minutes::MAX)
        )->plus(
            $this->seconds->value->div(
                Minutes::MAX * Seconds::MAX
            )
        );
        return $decimal->mul($this->direction->value);
    }

    /**
     * Gets the radian representation of this angle.
     *
     * @param integer|null $precision The number of digits after the decimal point.
     * @return float The angular value expressed as a radian number.
     */
    public function toRadian(int|null $precision = null): float
    {
        // If the angle was built from a radian value.
        if ($this->original_radian) {
            if ($precision)
                return round(
                    $this->original_radian,
                    $precision,
                    RoundingMode::HalfTowardsZero
                );
            else return $this->original_radian;
        }
        // If the angle was built from a decimal degrees value.
        if ($this->original_decimal) {
            if ($precision)
                return $this->original_radian = round(
                    deg2rad($this->original_decimal),
                    $precision,
                    RoundingMode::HalfTowardsZero
                );
            else return deg2rad($this->original_decimal);
        }
        // All other cases.
        if ($precision) {
            return $this->original_radian = round(
                deg2rad($this->toFloat()),
                $precision,
                RoundingMode::HalfTowardsZero
            );
        }
        return $this->original_radian = round(
            deg2rad($this->toFloat()),
            PHP_FLOAT_DIG,
            RoundingMode::HalfTowardsZero
        );
    }

    /**
     * Check if this `Angle` is greater than `$angle`.
     * 
     * @param int $precision The precision used when `$angle` is a `float`.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function isGreaterThan(string|int|float|AngleInterface $angle, int $precision = 54): bool
    {
        $comparison = new Greater($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    /**
     * Alias of `isGreaterThan()` method.
     *
     * @param int $precision The precision used when `$angle` is a `float`.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function gt(string|int|float|AngleInterface $angle, int $precision = 54): bool
    {
        return $this->isGreaterThan($angle, $precision);
    }

    /**
     * Check if this `Angle` is greater than or equal to `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float`.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function isGreaterThanOrEqualTo(string|int|float|AngleInterface $angle, int $precision = 54): bool
    {
        $comparison = new GreaterOrEqual($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    /**
     * Alias of `isGreaterThanOrEqualTo()` method.
     *
     * @param int $precision The precision used when $angle is a `float`.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function gte(string|int|float|AngleInterface $angle, int $precision = 54): bool
    {
        return $this->isGreaterThanOrEqualTo($angle, $precision);
    }

    /**
     * Check if this `Angle` is less than another `$angle`.
     *
     * @param string|int|float|AngleInterface $angle
     * @param int $precision The precision used when $angle is a `float`.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function isLessThan(string|int|float|AngleInterface $angle, int $precision = 54): bool
    {
        $comparison = new Lesser($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    /**
     * Alias of `isLessThan()` method.
     *
     * @param string|int|float|AngleInterface $angle
     * @param int $precision The precision used when $angle is a `float`.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function lt(string|int|float|AngleInterface $angle, int $precision = 54): bool
    {
        return $this->isLessThan($angle);
    }

    /**
     * Check if this `Angle` is less than or equal to `$angle`.
     *
     * @param string|int|float|AngleInterface $angle
     * @param int $precision The precision used when $angle is a `float`.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function isLessThanOrEqualTo(string|int|float|AngleInterface $angle, int $precision = 54): bool
    {
        $comparison = new LesserOrEqual($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    
    /**
     * Alias of `isLessThanOrEqual()` method.
     *
     * @param string|int|float|AngleInterface $angle
     * @param int $precision The precision used when $angle is a `float`.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function lte(string|int|float|AngleInterface $angle, int $precision = 54): bool
    {
        return $this->isLessThanOrEqualTo($angle);
    }

    /**
     * Check if this `Angle` is equal to `$angle`.
     *
     * @param string|int|float|AngleInterface $angle
     * @param int $precision The precision used when $angle is a `float`.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function isEqualTo(string|int|float|AngleInterface $angle, int $precision = 54): bool
    {
        $comparison = new Equal($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    /**
     * Alias of `isEqualTo()` method.
     *
     * @param string|int|float|AngleInterface $angle
     * @param int $precision The precision used when $angle is a `float`.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function eq(string|int|float|AngleInterface $angle, int $precision = 54): bool
    {
        return $this->isEqualTo($angle, $precision);
    }

    /**
     * Check if this `Angle` is different than `$angle`.
     *
     * @param string|int|float|AngleInterface $angle
     * @param int $precision The precision used when $angle is a `float`.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function isDifferentThan(string|int|float|AngleInterface $angle, int $precision = 54): bool
    {
        $comparison = new Different($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    /**
     * Alias for `isDifferentThan()` method.
     *
     * @param string|int|float|AngleInterface $angle
     * @param int $precision The precision used when $angle is a `float`.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function not(string|int|float|AngleInterface $angle, int $precision = 54): bool {
        return $this->isDifferentThan($angle, $precision);
    }

    /**
     * Return the sexagesimal value of this `Angle`.
     *
     * @return string
     * @example `(string) $alfa`
     */
    public function __toString()
    {
        $sign = $this->isClockwise() ? "-" : "";
        return "{$sign}{$this->degrees} {$this->minutes} {$this->seconds}";
    }

    /**
     * Count the decimal digits of a decimal number.
     *
     * @param float $number
     * @return integer The number of decimal digits after the decimal separator.
     */
    public static function countDecimalPlaces(float $number): int
    {
        for ($decimal_digits = 0; $number != round($number, $decimal_digits); $decimal_digits++);
        return $decimal_digits;
    }
}