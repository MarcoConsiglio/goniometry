<?php declare(strict_types=1);
namespace MarcoConsiglio\Goniometry;

use MarcoConsiglio\Goniometry\Builders\AbsoluteSum;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Exceptions\RegExFailureException;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Builders\RelativeSum;
use MarcoConsiglio\Goniometry\Casting\Radian\Cast as CastToRadian;
use MarcoConsiglio\Goniometry\Casting\Radian\Round as RoundFromRadian;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast as CastToSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round as RoundFromSexadecimal;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use MarcoConsiglio\Goniometry\Interfaces\AngleBuilder;

/**
 * Represents an angle.
 */
class Angle implements AngleInterface
{
    /**
     * Regular expression used to parse degrees value as integer number.
     */
    public const DEGREES_REGEX = "/(?<!\d)(-?(?:360|3[0-5]\d|[12]?\d{1,2}))°/";

    /**
     * Regular expression used to parse minutes value as integer number.
     */
    public const MINUTES_REGEX = '/\b([0-5]?\d)\'/';

    /**
     * Regular expression used to parse second value as decimal number.
     */
    public const SECONDS_REGEX = '/\b((?:[1-5]?\d)(?:\.\d+)?)"/';

    /**
     * The degrees part.
     */
    public Degrees $degrees {
        get {return $this->sexagesimal->degrees;}
    }

    /**
     * The minutes part.
     */
    public Minutes $minutes {
        get {return $this->sexagesimal->minutes;}
    }

    /**
     * The seconds part.
     */
    public Seconds $seconds {
        get {return $this->sexagesimal->seconds;}
    }

    
    /** 
     * The angle direction.
    */
    public Direction $direction {
        get {return $this->sexagesimal->direction;}
    }

    /**
     * The sexagesimal value of this `Angle`.
     */
    protected SexagesimalDegrees $sexagesimal;
    
    /** 
     * The sexadecimal degrees value of this `Angle`.
     */
    protected SexadecimalDegrees|null $sexadecimal = null;

    /** 
     * The radian degrees of this `Angle`.
     */
    protected Radian|null $radian = null;


    /**
     * Construct an `Angle`.
     */
    protected function __construct(AngleBuilder $builder)
    {
        [
            $this->sexagesimal,
            $this->sexadecimal,
            $this->radian
        ] = $builder->fetchData();
    }

    /**
     * Creates an angle from its values.
     */
    public static function createFromValues(int $degrees = 0, int $minutes = 0, float $seconds = 0.0, Direction $direction = Direction::COUNTER_CLOCKWISE): Angle
    {
        return new Angle(new FromDegrees($degrees, $minutes, $seconds, $direction));
    }

    /**
     * Creates an angle from its textual representation.
     * 
     * @throws NoMatchException when $angle has no match.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public static function createFromString(string $angle): Angle
    {
        return new Angle(new FromString($angle));
    }

    /**
     * Creates an angle from its decimal representation.
     */
    public static function createFromDecimal(float|SexadecimalDegrees $decimal_degrees): Angle
    {
        return new Angle(new FromDecimal($decimal_degrees));
    }

    /**
     * Creates an angle from its radian representation.
     */
    public static function createFromRadian(float|Radian $radian): Angle
    {
         return new Angle(new FromRadian($radian));
    }

    /**
     * Sums two relative angles.
     * 
     * The result can be positive or negative.
     */
    public static function sum(AngleInterface $alfa, AngleInterface $beta): Angle
    {
        return new Angle(new RelativeSum($alfa, $beta));
    }

    /**
     * Sums two absolute angles.
     * 
     * The result can be only positive.
     */
    public static function absSum(AngleInterface $alfa, AngleInterface $beta): Angle
    {
        return new Angle(new AbsoluteSum($alfa, $beta));
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
        $degrees = (int) $this->degrees->value() * $this->direction->value;
        $minutes = $this->minutes->value();
        $seconds = $this->seconds->value();
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
     */
    public function isClockwise(): bool
    {
        return $this->direction == Direction::CLOCKWISE;
    }

    /**
     * Check if this angle is counterclockwise or positive.
     */
    public function isCounterClockwise(): bool
    {
        return $this->direction == Direction::COUNTER_CLOCKWISE;
    }

    /**
     * Return the same instance but the opposite direction.
     */
    public function toggleDirection(): Angle
    {
        $clone = clone $this;
        $clone->sexagesimal->direction =
            $clone->sexagesimal->direction->opposite();
        return $clone;
    }

    /**
     * Return the sexadecimal value of this `Angle` with arbitrary 
     * precision.
     */
    public function toSexadecimalDegrees(): SexadecimalDegrees
    {
        if ($this->sexadecimal !== null)
            return $this->sexadecimal;
        return $this->sexadecimal = new SexadecimalDegrees(
            $this->degrees->value->plus(
                $this->minutes->value->div(Minutes::MAX)
            )->plus(
                $this->seconds->value->div(Minutes::MAX * Seconds::MAX)
            )->mul($this->direction->value)
        );
    }

    /**
     * Return the sexadecimal value of this `Angle`.
     *
     * @param integer|null $precision The number of decimal digits. If sets to null,
     * it resolve the original precision at the time this Angle was built.
     */
    public function toFloat(int|null $precision = null): float
    {
        if ($this->sexadecimal !== null)
            return new RoundFromSexadecimal($this->sexadecimal, $precision)->cast();
        return new CastToSexadecimal($this, $precision)->cast();
    }

    /**
     * Return the radian representation of this angle.
     *
     * @param integer|null $precision The number of decimal digits. If null, 
     * return the value with the maximum available precision.
     */
    public function toRadian(int|null $precision = null): float
    {
        if ($this->radian !== null)
            return new RoundFromRadian($this->radian, $precision)->cast();
        return new CastToRadian($this, $precision)->cast();
    }

    /**
     * Check if this `Angle` is greater than `$angle`.
     * 
     * @param int $precision The precision used when `$angle` is a `float` type variable.
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
     * @param int $precision The precision used when `$angle` is a `float` type variable.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function gt(string|int|float|AngleInterface $angle, int $precision = 54): bool
    {
        return $this->isGreaterThan($angle, $precision);
    }

    /**
     * Check if this `Angle` is greater than or equal to `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type variable.
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
     * @param int $precision The precision used when `$angle` is a `float` type variable.
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
     * @param int $precision TThe precision used when `$angle` is a `float` type variable.
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
     * @param int $precision The precision used when `$angle` is a `float` type variable.
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
     * @param int $precision The precision used when `$angle` is a `float` type variable.
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
     * @param int $precision The precision used when `$angle` is a `float` type variable.
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
     * @param int $precision The precision used when `$angle` is a `float` type variable.
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
     * @param int $precision The precision used when `$angle` is a `float` type variable.
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
     * @param int $precision The precision used when `$angle` is a `float` type variable.
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
     * @param int $precision The precision used when `$angle` is a `float` type variable.
     * @throws RegExFailureException when there's a failure in regex parser engine.
     */
    public function not(string|int|float|AngleInterface $angle, int $precision = 54): bool {
        return $this->isDifferentThan($angle, $precision);
    }

    /**
     * Return the sexagesimal value of this `Angle`.
     * 
     * @example `(string) $alfa`
     */
    public function __toString()
    {
        $sign = $this->isClockwise() ? "-" : "";
        return "{$sign}{$this->degrees} {$this->minutes} {$this->seconds}";
    }
}