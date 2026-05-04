<?php
namespace MarcoConsiglio\Goniometry;

use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromRadian;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromString;
use MarcoConsiglio\Goniometry\Casting\Radian\Cast as CastToRadian;
use MarcoConsiglio\Goniometry\Casting\Radian\Round as FromSexadecimalToRadian;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast as CastToSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round as FromSexadecimalToFloat;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Fuzzy\Equal as FuzzyEqual;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use MarcoConsiglio\Goniometry\Interfaces\AngleBuilder;
use Override;
use Stringable;

class AngularDistance implements AngleInterface, Stringable
{
    public const int MAX = 180;

    public const int MIN = -self::MAX;
    
    /**
     * The `Degrees` part.
     */
    public Degrees $degrees {
        get {return $this->sexagesimal->degrees;}
    }

    /**
     * The `Minutes` part.
     */
    public Minutes $minutes {
        get {return $this->sexagesimal->minutes;}
    }

    /**
     * The `Seconds` part.
     */
    public Seconds $seconds {
        get {return $this->sexagesimal->seconds;}
    }
    
    /** 
     * The `AngularDistance` `Direction`.
    */
    public Direction $direction {
        get {return $this->sexagesimal->direction;}
    }

    public protected(set) SexagesimalDegrees $sexagesimal;

    public protected(set) SexadecimalAngularDistance|null $sexadecimal;

    public protected(set) AngularDistanceRadian|null $radian;

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
     * Creates an `Angle` from its sexagesimal values.
     */
    #[Override]
    public static function createFromValues(
        int $degrees = 0, 
        int $minutes = 0, 
        float $seconds = 0.0, 
        Direction $direction = Direction::COUNTER_CLOCKWISE
    ): AngularDistance
    {
        return new AngularDistance(
            new FromSexagesimal($degrees, $minutes, $seconds, $direction)
        );
    }

    /**
     * Creates an `Angle` from its sexadecimal representation.
     */
    #[Override]
    public static function createFromDecimal(
        float|SexadecimalAngularDistance $sexadecimal
    ): AngularDistance {
        return new AngularDistance(new FromSexadecimal($sexadecimal));
    }

    /**
     * Creates an `Angle` from its textual sexagesimal representation.
     * 
     * @throws NoMatchException when bad formatted angle is found.
     */
    #[Override]
    public static function createFromString(string $sexagesimal): AngularDistance
    {
        return new AngularDistance(new FromString($sexagesimal));
    }

    /**
     * Creates an `Angle` from its radian representation.
     */
    #[Override]
    public static function createFromRadian(float|AngularDistanceRadian $radian): AngularDistance
    {
        return new AngularDistance(new FromRadian($radian));
    }

    /**
     * Return an array containing separate sexagesimal values.
     * 
     * The direction of the `Angle` is the sign of `"degrees"` value.
    *
    * @param bool $associative Set to true it returns an associative array.
    * @param int $precision The precision used in seconds.
    * @return array{int,int,float}|array{degrees:int,minutes:int,seconds:float}
    */
    #[Override]
    public function getDegrees(bool $associative = false, int $precision = PHP_FLOAT_DIG): array
    {
        $degrees = $this->degrees->value() * $this->direction->value;
        $minutes = $this->minutes->value();
        $seconds = $this->seconds->value($precision);
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
     * Return an absolute `Angle`
     */
    #[Override]
    public function absolute(): AngularDistance
    {
        return AngularDistance::createFromDecimal(
            new SexadecimalAngularDistance(
                $this->toSexadecimalDegrees()->value->abs()
            )
        );
    }

    /**
     * Alias of `absolute()` method.
     */
    #[Override]
    public function asb(): AngularDistance
    {
        return $this->absolute();
    }

    #[Override]
    public function toggleDirection(): AngularDistance
    {
        $clone = clone $this;
        $clone->sexagesimal->direction =
            $clone->sexagesimal->direction->opposite();
        $clone->sexadecimal = new SexadecimalAngularDistance(
            $clone->sexadecimal->value->mul(-1)
        );
        return $clone;
    }

    #[Override]
    public function isClockwise(): bool
    {
        return $this->direction == Direction::CLOCKWISE;
    }

    #[Override]
    public function isCounterClockwise(): bool
    {
        return $this->direction == Direction::COUNTER_CLOCKWISE;
    }

    public function toSexadecimalDegrees(): SexadecimalAngularDistance
    {
        if ($this->sexadecimal !== null)
            return $this->sexadecimal;
        return $this->sexadecimal = new SexadecimalAngularDistance(
            $this->degrees->value->plus(
                $this->minutes->value->div(Minutes::MAX)
            )->plus(
                $this->seconds->value->div(Minutes::MAX * Seconds::MAX)
            )->mul($this->direction->value)
        );
    }

    #[Override]
    public function toSexagesimalDegrees(): SexagesimalDegrees
    {
        return $this->sexagesimal;
    }

    #[Override]
    public function toFloat(int|null $precision = null): float
    {
        if ($this->sexadecimal !== null)
            return new FromSexadecimalToFloat($this->sexadecimal, $precision)->cast();
        return new CastToSexadecimal($this, $precision)->cast();
    }

    #[Override]
    public function toRadian(int|null $precision = null): float
    {
        if ($this->radian !== null)
            return new FromSexadecimalToRadian($this->radian, $precision)->cast();
        return new CastToRadian($this, $precision)->cast();
    }

    #[Override]
    public function isEqualTo(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        $comparison = new Equal($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    #[Override]
    public function eq(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isEqualTo($angle, $precision);
    }

    #[Override]
    public function isDifferentThan(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        $comparison = new Different($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    #[Override]
    public function not(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isDifferentThan($angle, $precision);
    }

    #[Override]
    public function isGreaterThan(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        $comparison = new Greater($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    #[Override]
    public function gt(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isGreaterThan($angle, $precision);
    }

    #[Override]
    public function isGreaterThanOrEqualTo(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        $comparison = new GreaterOrEqual($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    #[Override]
    public function gte(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isGreaterThan($angle, $precision);
    }

    #[Override]
    public function isLessThan(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        $comparison = new Lesser($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    #[Override]
    public function lt(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isLessThan($angle, $precision);
    }

    #[Override]
    public function isLessThanOrEqualTo(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        $comparison = new LesserOrEqual($this, $angle);
        if (is_float($angle)) $comparison->setPrecision($precision);
        return $comparison->compare();
    }

    #[Override]
    public function lte(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        return $this->isLessThanOrEqualTo($angle, $precision);
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
     * Check if this `Angle` is equal to `$beta` within an acceptable `$delta` 
     * error angle.
     */
    #[Override]
    public function fuzzyEqual(AngleInterface $beta, AngleInterface $delta): bool
    {
        return new FuzzyEqual($this, $beta, $delta)->compare();
    }

    /**
     * Alias for `fuzzyEqual()` method.
     */
    #[Override]
    public function feq(AngleInterface $beta, AngleInterface $delta): bool
    {
        return $this->fuzzyEqual($beta, $delta);
    }
}