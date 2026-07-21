<?php declare(strict_types=1);
namespace MarcoConsiglio\Goniometry;

use MarcoConsiglio\Goniometry\Builders\Angle\AbsoluteSum;
use MarcoConsiglio\Goniometry\Builders\Angle\FromRadian;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromString;
use MarcoConsiglio\Goniometry\Builders\Angle\RelativeSum;
use MarcoConsiglio\Goniometry\Builders\Builder;
use MarcoConsiglio\Goniometry\Casting\Radian\Cast as CastToRadian;
use MarcoConsiglio\Goniometry\Casting\Radian\Round as RoundFromRadian;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast as CastToSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round as RoundFromSexadecimal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Equal as FuzzyEqual;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Interfaces\Angle\BuildableFromRadian;
use MarcoConsiglio\Goniometry\Interfaces\Angle\BuildableFromSexadecimal;
use MarcoConsiglio\Goniometry\Interfaces\Angle\Comparable;
use MarcoConsiglio\Goniometry\Interfaces\Angle\FuzzyComparable;
use MarcoConsiglio\Goniometry\Interfaces\Angle\Summable;
use Override;

/**
 * The `Angle` type.
 */
class Angle extends AngularMeasure implements 
    BuildableFromRadian, 
    BuildableFromSexadecimal,
    Comparable,
    FuzzyComparable,
    Summable
{
    /** 
     * The sexadecimal degrees value of this `Angle`.
     */
    protected SexadecimalAngle|null $sexadecimal = null;

    /** 
     * The radian value of this `Angle`.
     */
    protected RadianAngle|null $radian = null;

    /**
     * Construct an `Angle`.
     */
    protected function __construct(Builder $builder)
    {
        [
            $this->sexagesimal,
            $this->sexadecimal,
            $this->radian
        ] = $builder->fetchData();
    }

    /**
     * Creates an `Angle` from its sexagesimal values.
     */
    public static function createFromValues(
        int $degrees = 0, 
        int $minutes = 0, 
        float $seconds = 0.0, 
        Rotation $direction = Rotation::COUNTER_CLOCKWISE
    ): static {
        return new static(new FromSexagesimal($degrees, $minutes, $seconds, $direction));
    }

    /**
     * Creates an `Angle` from its textual sexagesimal representation.
     * 
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public static function createFromString(string $sexagesimal): static
    {
        return new static(new FromString($sexagesimal));
    }

    /**
     * Creates an `Angle` from its sexadecimal representation.
     */
    public static function createFromDecimal(float|SexadecimalAngle $sexadecimal): static
    {
        return new static(new FromSexadecimal($sexadecimal));
    }

    /**
     * Creates an `Angle` from its radian representation.
     */
    public static function createFromRadian(float|RadianAngle $radian): static
    {
         return new static(new FromRadian($radian));
    }

    /**
     * Return this `Angle` as absolute (positive).
     */
    public function absolute(): static
    {
        return static::createFromDecimal(
            new SexadecimalAngle(
                $this->toSexadecimalDegrees()->value->abs()
            )
        );
    }

    /**
     * Alias for `absolute()` method.
     */
    public function asb(): static
    {
        return $this->absolute();
    }

    /**
     * Check if this `Angle` is clockwise or negative.
     */
    public function isClockwise(): bool
    {
        return $this->direction == Rotation::CLOCKWISE;
    }

    /**
     * Check if this `Angle` is counterclockwise or positive.
     */
    public function isCounterClockwise(): bool
    {
        return $this->direction == Rotation::COUNTER_CLOCKWISE;
    }

    /**
     * Return the same instance with the opposite `Rotation` direction.
     */
    public function oppositeRotation(): static
    {
        $clone = clone $this;
        $clone->sexagesimal->direction =
            $clone->sexagesimal->direction->opposite();
        if ($clone->sexadecimal !== null)
            $clone->sexadecimal = new SexadecimalAngle(
                $clone->sexadecimal->value->mul(-1)
            );
        return $clone;
    }

    /**
     * Cast this `Angle` to `SexadecimalDegrees`.
     */
    public function toSexadecimalDegrees(): SexadecimalAngle
    {
        if ($this->sexadecimal !== null)
            return $this->sexadecimal;
        return $this->sexadecimal = new SexadecimalAngle(
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
     * Return the sexadecimal `float` value of this `Angle`.
     *
     * @param integer|null $precision The number of decimal digits.
     */
    public function toFloat(int|null $precision = null): float
    {
        if ($this->sexadecimal !== null)
            return new RoundFromSexadecimal($this->sexadecimal, $precision)->cast();
        return new CastToSexadecimal($this, $precision)->cast();
    }

    /**
     * Return the radian representation of this `Angle`.
     *
     * @param integer|null $precision The number of decimal digits.
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
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public function isGreaterThan(
        string|int|float|AngularMeasure $angle, 
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
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public function gt(
        string|int|float|AngularMeasure $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isGreaterThan($angle, $precision);
    }

    /**
     * Check if this `Angle` is greater than or equal to `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public function isGreaterThanOrEqualTo(
        string|int|float|AngularMeasure $angle, 
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
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public function gte(
        string|int|float|AngularMeasure $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isGreaterThanOrEqualTo($angle, $precision);
    }

    /**
     * Check if this `Angle` is less than another `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public function isLessThan(
        string|int|float|AngularMeasure $angle, 
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
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public function lt(
        string|int|float|AngularMeasure $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isLessThan($angle);
    }

    /**
     * Check if this `Angle` is less than or equal to `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public function isLessThanOrEqualTo(
        string|int|float|AngularMeasure $angle, 
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
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public function lte(
        string|int|float|AngularMeasure $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isLessThanOrEqualTo($angle);
    }

    /**
     * Check if this `Angle` is equal to `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public function isEqualTo(
        string|int|float|AngularMeasure $angle, 
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
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public function eq(
        string|int|float|AngularMeasure $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isEqualTo($angle, $precision);
    }

    /**
     * Check if this `Angle` is different than `$angle`.
     *
     * @param int $precision The precision used when `$angle` is a `float` type
     * variable.
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public function isDifferentThan(
        string|int|float|AngularMeasure $angle, 
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
     * @throws NoMatchException when bad formatted `string` `$angle` is found.
     */
    public function not(
        string|int|float|AngularMeasure $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isDifferentThan($angle, $precision);
    }

    /**
     * Check if this `Angle` is equal to `$beta` within an acceptable `$delta` 
     * error angle.
     */
    public function fuzzyEqual(AngularMeasure $beta, AngularMeasure $delta): bool
    {
        return new FuzzyEqual($this, $beta, $delta)->compare();
    }

    /**
     * Alias for `fuzzyEqual()` method.
     */
    public function feq(AngularMeasure $beta, AngularMeasure $delta): bool
    {
        return $this->fuzzyEqual($beta, $delta);
    }

    /**
     * Sum this `Angle` to an `$addend`. The resulting `Angle` can be positive or negative.
     */
    public function sum(AngularMeasure $addend): static
    {
        return new static(new RelativeSum($this, $addend));
    }

    /**
     * Sum this `Angle` to an `$addend` two absolute `Angle`s. The resulting `Angle` can be only positive.
     */
    public function absSum(AngularMeasure $addend): static
    {
        return new static(new AbsoluteSum($this, $addend));
    }

    /**
     * Return the opposite direction `Angle`.
     */
    #[Override]
    public function oppositeDirection(): static
    {
        $opposite = static::createFromValues(180, direction: Rotation::CLOCKWISE);
        if ($this->isClockwise())
            return $this->sum($opposite);
        else
            return $this->absSum($opposite);
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