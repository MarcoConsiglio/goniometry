<?php
namespace MarcoConsiglio\Goniometry;

use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromRadian;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromString;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use MarcoConsiglio\Goniometry\Interfaces\AngleBuilder;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round as RoundFromSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast as CastToSexadecimal;
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

    #[Override]
    public function toggleDirection(): AngularDistance
    {
        $clone = clone $this;
        if ($clone->sexagesimal !== null)
            $clone->sexagesimal->direction =
                $clone->sexagesimal->direction->opposite();
        if ($clone->sexadecimal !== null)
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

    public function toSexadecimalAngularDistance(): SexadecimalAngularDistance
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
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function toFloat(int|null $precision = null): float
    {
        if ($this->sexadecimal !== null)
            return new RoundFromSexadecimal($this->sexadecimal, $precision)->cast();
        return new CastToSexadecimal($this, $precision)->cast();
    }

    #[Override]
    public function toRadian(int|null $precision = null): float
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isEqualTo(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function eq(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isDifferentThan(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function not(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isGreaterThan(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function gt(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isGreaterThanOrEqualTo(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function gte(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isLessThan(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function lt(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isLessThanOrEqualTo(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function lte(
        string|int|float|AngleInterface $angle, 
        int $precision = Comparison::MAX_PRECISION
    ): bool {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function __toString(): string
    {
        throw new \Exception('Not implemented');
    }
}