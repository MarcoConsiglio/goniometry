<?php declare(strict_types=1);
namespace MarcoConsiglio\Goniometry;

use MarcoConsiglio\Goniometry\Builders\AbsoluteSum;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Exceptions\RegExFailureException;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Builders\RelativeSum;
use MarcoConsiglio\Goniometry\Casting\Radian\Cast as CastToRadian;
use MarcoConsiglio\Goniometry\Casting\Radian\Round as RoundFromRadian;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast as CastToSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round as RoundFromSexadecimal;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Fuzzy\Equal as FuzzyEqual;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use MarcoConsiglio\Goniometry\Interfaces\AngleBuilder;
use Stringable;

/**
 * Represents an angle.
 */
class Angle implements AngleInterface, Stringable
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
     * Creates an `Angle` from its values.
     */
    public static function createFromValues(int $degrees = 0, int $minutes = 0, float $seconds = 0.0, Direction $direction = Direction::COUNTER_CLOCKWISE): Angle
    {
        return new Angle(new FromSexagesimal($degrees, $minutes, $seconds, $direction));
    }

    /**
     * Creates an `Angle` from its textual representation.
     * 
     * @throws NoMatchException when $angle has no match.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public static function createFromString(string $sexagesimal): Angle
    {
        return new Angle(new FromString($sexagesimal));
    }

    /**
     * Creates an `Angle` from its decimal representation.
     */
    public static function createFromDecimal(float|SexadecimalDegrees $sexadecimal): Angle
    {
        return new Angle(new FromSexadecimal($sexadecimal));
    }

    /**
     * Creates an `Angle` from its radian representation.
     */
    public static function createFromRadian(float|Radian $radian): Angle
    {
         return new Angle(new FromRadian($radian));
    }

    /**
     * Sums two relative `Angle`s.
     * 
     * The result can be positive or negative.
     */
    public static function sum(AngleInterface $alfa, AngleInterface $beta): Angle
    {
        return new Angle(new RelativeSum($alfa, $beta));
    }

    /**
     * Sums two absolute `Angle`s.
     * 
     * The result can be only positive.
     */
    public static function absSum(AngleInterface $alfa, AngleInterface $beta): Angle
    {
        return new Angle(new AbsoluteSum($alfa, $beta));
    }

    /**
     * Return an array containing separate sexagesimal values.
     * 
     * The direction of the `Angle` is the sign of `"degrees"` value.
     *
     * @param bool $associative Set to true it returns an associative array.
     * @return array{int,int,float}|array{degrees:int,minutes:int,seconds:float}
     */
    public function getDegrees(bool $associative = false): array
    {
        $degrees = $this->degrees->value() * $this->direction->value;
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
     * Check if this `Angle` is clockwise or negative.
     */
    public function isClockwise(): bool
    {
        return $this->direction == Direction::CLOCKWISE;
    }

    /**
     * Check if this `Angle` is counterclockwise or positive.
     */
    public function isCounterClockwise(): bool
    {
        return $this->direction == Direction::COUNTER_CLOCKWISE;
    }

    /**
     * Return the same instance with the opposite direction.
     */
    public function toggleDirection(): Angle
    {
        $clone = clone $this;
        $clone->sexagesimal->direction =
            $clone->sexagesimal->direction->opposite();
        if ($clone->sexadecimal !== null)
            $clone->sexadecimal = new SexadecimalDegrees(
                $clone->sexadecimal->value->mul(-1)
            );
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
     * Return the sexagesimal values of this `Angle`.
     */
    public function toSexagesimalDegrees(): SexagesimalDegrees
    {
        return $this->sexagesimal;
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
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public function isGreaterThan(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        $comparison = new Greater($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    /**
     * Alias of `isGreaterThan()` method.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public function gt(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isGreaterThan($angle, $precision);
    }

    /**
     * Check if this `Angle` is greater than or equal to `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public function isGreaterThanOrEqualTo(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool
    {
        $comparison = new GreaterOrEqual($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    /**
     * Alias of `isGreaterThanOrEqualTo()` method.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public function gte(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isGreaterThanOrEqualTo($angle, $precision);
    }

    /**
     * Check if this `Angle` is less than another `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public function isLessThan(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        $comparison = new Lesser($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    /**
     * Alias of `isLessThan()` method.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public function lt(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isLessThan($angle);
    }

    /**
     * Check if this `Angle` is less than or equal to `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public function isLessThanOrEqualTo(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        $comparison = new LesserOrEqual($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    
    /**
     * Alias of `isLessThanOrEqual()` method.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public function lte(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isLessThanOrEqualTo($angle);
    }

    /**
     * Check if this `Angle` is equal to `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public function isEqualTo(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        $comparison = new Equal($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    /**
     * Alias of `isEqualTo()` method.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public function eq(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isEqualTo($angle, $precision);
    }

    /**
     * Check if this `Angle` is different than `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public function isDifferentThan(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        $comparison = new Different($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    /**
     * Alias for `isDifferentThan()` method.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws RegExFailureException when there's a failure in regex parser 
     * engine while `$angle` is a `string` type variable.
     */
    public function not(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isDifferentThan($angle, $precision);
    }

    /**
     * Check if this `Angle` is equal to `$beta` within an acceptable `$delta` 
     * error angle.
     */
    public function fuzzyEqual(Angle $beta, Angle $delta): bool
    {
        return new FuzzyEqual($this, $beta, $delta)->compare();
    }

    /**
     * Alias for `fuzzyEqual()` method.
     */
    public function feq(Angle $beta, Angle $delta): bool
    {
        return $this->fuzzyEqual($this, $beta, $delta);
    }

    /**
     * Return the sexagesimal value of this `Angle`.
     * 
     * @example `(string) $alfa`
     */
    public function __toString(): string
    {
        $sign = $this->isClockwise() ? "-" : "";
        return "{$sign}{$this->degrees} {$this->minutes} {$this->seconds}";
    }
}