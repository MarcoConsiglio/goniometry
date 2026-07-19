<?php
namespace MarcoConsiglio\Goniometry;

use MarcoConsiglio\Goniometry\Builders\Angle\AngleBuilder;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromAngles;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromRadian;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromString;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\RelativeSum;
use MarcoConsiglio\Goniometry\Casting\Radian\Cast as CastToRadian;
use MarcoConsiglio\Goniometry\Casting\Radian\Round as RoundRadian;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast as CastToSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round as RoundSexadecimal;
use MarcoConsiglio\Goniometry\Comparisons\Comparison as GeneralComparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Equal as FuzzyEqual;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Interfaces\AngularDistance\BuildableFromRadian;
use MarcoConsiglio\Goniometry\Interfaces\AngularDistance\BuildableFromSexadecimal;
use MarcoConsiglio\Goniometry\Interfaces\AngularDistance\Comparable;
use MarcoConsiglio\Goniometry\Interfaces\AngularDistance\FuzzyComparable;
use MarcoConsiglio\Goniometry\Interfaces\RadianValue;
use Override;

/**
 * The `AngularDistance` type.
 */
class AngularDistance extends AngularMeasure implements
    BuildableFromRadian,
    BuildableFromSexadecimal,
    Comparable,
    FuzzyComparable
{
    /**
     * The maximum allowed value in degrees.
     */
    public const int MAX = 180;

    /**
     * The minimum allowed value in degrees.
     */
    public const int MIN = -self::MAX;

    /** 
     * The sexadecimal degrees value of this `Angle`.
     */
    protected SexadecimalAngularDistance|null $sexadecimal = null;

    /** 
     * The radian value of this `Angle`.
     */
    protected RadianAngularDistance|null $radian = null;

    /**
     * Construct an `AngularDistance`.
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
     * Creates an `AngularDistance` from its sexagesimal values.
     */
    #[Override]
    public static function createFromValues(
        int $degrees = 0, 
        int $minutes = 0, 
        float $seconds = 0.0, 
        Rotation $direction = Rotation::COUNTER_CLOCKWISE
    ): static
    {
        return new static(
            new FromSexagesimal($degrees, $minutes, $seconds, $direction)
        );
    }

    /**
     * Creates an `AngularDistance` from its sexadecimal representation.
     */
    #[Override]
    public static function createFromDecimal(
        float|SexadecimalAngularDistance $sexadecimal
    ): static {
        return new static(new FromSexadecimal($sexadecimal));
    }

    /**
     * Creates an `AngularDistance` from its textual sexagesimal representation.
     * 
     * @throws NoMatchException when bad formatted angle is found.
     */
    #[Override]
    public static function createFromString(string $sexagesimal): static
    {
        return new static(new FromString($sexagesimal));
    }

    /**
     * Creates an `AngularDistance` from its radian representation.
     */
    #[Override]
    public static function createFromRadian(float|RadianValue $radian): static
    {
        return new static(new FromRadian($radian));
    }

    /**
     * Calc the `AngularDistance` between `$alfa` and `$beta`.
     */
    public static function between(Angle $alfa, Angle $beta): AngularDistance
    {
        return new AngularDistance(new FromAngles($alfa, $beta));
    }

    /**
     * Return an absolute `AngularDistance`
     */
    #[Override]
    public function absolute(): static
    {
        return static::createFromDecimal(
            new SexadecimalAngularDistance(
                $this->toSexadecimalDegrees()->value->abs()
            )
        );
    }

    /**
     * Alias of `absolute()` method.
     */
    #[Override]
    public function asb(): static
    {
        return $this->absolute();
    }

    /**
     * Return the same instance with the opposite `Rotation` direction.
     */
    #[Override]
    public function oppositeRotation(): static
    {
        $clone = clone $this;
        $clone->sexagesimal->direction =
            $clone->sexagesimal->direction->opposite();
        $clone->sexadecimal = new SexadecimalAngularDistance(
            $clone->sexadecimal->value->mul(-1)
        );
        return $clone;
    }

    /**
     * Check if this `AngularDistance` is clockwise or negative.
     */
    #[Override]
    public function isClockwise(): bool
    {
        return $this->direction == Rotation::CLOCKWISE;
    }

    /**
     * Check if this `AngularDistance` is counterclockwise or positive.
     */
    #[Override]
    public function isCounterClockwise(): bool
    {
        return $this->direction == Rotation::COUNTER_CLOCKWISE;
    }

    /**
     * Cast this `AngularDistance` to `SexadecimalAngularDistance`.
     */
    public function toSexadecimalDegrees(): SexadecimalAngularDistance
    {
        if ($this->sexadecimal !== null)
            return $this->sexadecimal;
        // @codeCoverageIgnoreStart
        return $this->sexadecimal = new SexadecimalAngularDistance(
            $this->degrees->value->plus(
                $this->minutes->value->div(Minutes::MAX)
            )->plus(
                $this->seconds->value->div(Minutes::MAX * Seconds::MAX)
            )->mul($this->direction->value)
        );
        // @codeCoverageIgnoreEnd
    }

    /**
     * Return the sexagesimal values of this `AngularDistance`.
     */
    #[Override]
    public function toSexagesimalDegrees(): SexagesimalDegrees
    {
        return $this->sexagesimal;
    }

    /**
     * Return the sexadecimal `float` value of this `AngularDistance`.
     *
     * @param integer|null $precision The number of decimal digits.
     */
    #[Override]
    public function toFloat(int|null $precision = null): float
    {
        if ($this->sexadecimal !== null)
            return new RoundSexadecimal($this->sexadecimal, $precision)->cast();
        // @codeCoverageIgnoreStart
        return new CastToSexadecimal($this, $precision)->cast();
        // @codeCoverageIgnoreEnd
    }

    /**
     * Return the radian representation of this `AngularDistance`e.
     *
     * @param integer|null $precision The number of decimal digits.
     */
    #[Override]
    public function toRadian(int|null $precision = null): float
    {
        if ($this->radian !== null)
            return new RoundRadian($this->radian, $precision)->cast();
        return new CastToRadian($this, $precision)->cast();
    }

    /**
     * Check if this `AngularDistance` is equal to `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    #[Override]
    public function isEqualTo(
        string|int|float|AngularMeasure $angle, 
        int $precision = GeneralComparison::MAX_PRECISION
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
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    #[Override]
    public function eq(
        string|int|float|AngularMeasure $angle, 
        int $precision = GeneralComparison::MAX_PRECISION
    ): bool {
        return $this->isEqualTo($angle, $precision);
    }

    /**
     * Check if this `AngularDistance` is different than `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    #[Override]
    public function isDifferentThan(
        string|int|float|AngularMeasure $angle, 
        int $precision = GeneralComparison::MAX_PRECISION
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
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    #[Override]
    public function not(
        string|int|float|AngularMeasure $angle, 
        int $precision = GeneralComparison::MAX_PRECISION
    ): bool {
        return $this->isDifferentThan($angle, $precision);
    }

    /**
     * Check if this `AngularDistance` is greater than `$angle`.
     * 
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    #[Override]
    public function isGreaterThan(
        string|int|float|AngularMeasure $angle, 
        int $precision = GeneralComparison::MAX_PRECISION
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
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    #[Override]
    public function gt(
        string|int|float|AngularMeasure $angle, 
        int $precision = GeneralComparison::MAX_PRECISION
    ): bool {
        return $this->isGreaterThan($angle, $precision);
    }

    /**
     * Check if this `AngularDistance` is greater than or equal to `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    #[Override]
    public function isGreaterThanOrEqualTo(
        string|int|float|AngularMeasure $angle, 
        int $precision = GeneralComparison::MAX_PRECISION
    ): bool {
        $comparison = new GreaterOrEqual($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    /**
     * Alias of `isGreaterThanOrEqualTo()` method.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    #[Override]
    public function gte(
        string|int|float|AngularMeasure $angle, 
        int $precision = GeneralComparison::MAX_PRECISION
    ): bool {
        return $this->isGreaterThanOrEqualTo($angle, $precision);
    }

    /**
     * Check if this `AngularDistance` is less than another `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    #[Override]
    public function isLessThan(
        string|int|float|AngularMeasure $angle, 
        int $precision = GeneralComparison::MAX_PRECISION
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
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    #[Override]
    public function lt(
        string|int|float|AngularMeasure $angle, 
        int $precision = GeneralComparison::MAX_PRECISION
    ): bool {
        return $this->isLessThan($angle, $precision);
    }

    /**
     * Check if this `AngularDistance` is less than or equal to `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    #[Override]
    public function isLessThanOrEqualTo(
        string|int|float|AngularMeasure $angle, 
        int $precision = GeneralComparison::MAX_PRECISION
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
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    #[Override]
    public function lte(
        string|int|float|AngularMeasure $angle, 
        int $precision = GeneralComparison::MAX_PRECISION
    ): bool {
        return $this->isLessThanOrEqualTo($angle, $precision);
    }

    /**
     * Check if this `Angle` is equal to `$beta` within an acceptable `$delta` 
     * error angle.
     */
    #[Override]
    public function fuzzyEqual(AngularMeasure $beta, AngularMeasure $delta): bool
    {
        return new FuzzyEqual($this, $beta, $delta)->compare();
    }

    /**
     * Alias for `fuzzyEqual()` method.
     */
    #[Override]
    public function feq(AngularMeasure $beta, AngularMeasure $delta): bool
    {
        return $this->fuzzyEqual($beta, $delta);
    }

    /**
     * Sum this `AngularDistance` to another `$addend`.
     */
    public function sum(AngularMeasure $addend): static
    {
        return new static(new RelativeSum($this, $addend));
    }

    /**
     * Alias of `sum()` method.
     */
    public function absSum(AngularMeasure $addend): static
    {
        return $this->sum($addend);
    }

    /**
     * Return the opposite direction `AngularDistance`.
     */
    #[Override]
    public function oppositeDirection(): static
    {
        $opposite = static::createFromValues(180, direction: Rotation::CLOCKWISE);
        return $this->sum($opposite);
    }

    /**
     * Return the sexagesimal value of this `Angle`.
     * 
     * @example `(string) $alfa`
     */
    #[Override]
    public function __toString(): string
    {
        $sign = $this->isClockwise() ? "-" : "";
        return "{$sign}{$this->degrees} {$this->minutes} {$this->seconds}";
    }

    /**
     * Clone this `Angle`.
     */
    public function __clone()
    {
        $this->sexagesimal = clone $this->sexagesimal;
        $this->sexadecimal = is_null($this->sexadecimal) ? null : clone $this->sexadecimal;
        $this->radian = is_null($this->radian) ? null : clone $this->radian;
    }
}