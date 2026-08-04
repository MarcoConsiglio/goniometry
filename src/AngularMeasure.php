<?php
namespace MarcoConsiglio\Goniometry;

use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Interfaces\BuildableFromSexagesimal;
use MarcoConsiglio\Goniometry\Interfaces\BuildableFromSexagesimalString;
use MarcoConsiglio\Goniometry\Interfaces\CastableToRadian;
use MarcoConsiglio\Goniometry\Interfaces\CastableToSexadecimal;
use MarcoConsiglio\Goniometry\Interfaces\CastableToSexagesimal;
use MarcoConsiglio\Goniometry\Interfaces\SexadecimalValue;
use Stringable;

/**
 * The concept of an angular measure.
 */
abstract class AngularMeasure implements 
    Stringable,
    BuildableFromSexagesimalString,
    BuildableFromSexagesimal,
    CastableToSexagesimal,
    CastableToSexadecimal,
    CastableToRadian
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
     * The `Angle` `Rotation` direction.
    */
    public Rotation $direction {
        get {return $this->sexagesimal->direction;}
    }

    /**
     * The sexagesimal value of this `Angle`.
     */
    protected SexagesimalDegrees $sexagesimal;

    abstract public static function createFromValues(
        int $degrees, 
        int $minutes, 
        float $seconds, 
        Rotation $direction
    ): static;
    
    abstract public static function createFromString(string $sexagesimal): static;

    abstract public function toRadian(int $precision = PHP_FLOAT_DIG): float;

    abstract public function toSexadecimalDegrees(): SexadecimalValue;

    abstract public function toFloat(int $precision = PHP_FLOAT_DIG): float;

    abstract public function toSexagesimalDegrees(): SexagesimalDegrees;

    abstract public function absolute(): static;

    abstract public function asb(): static;

    abstract public function oppositeRotation(): static;

    abstract public function oppositeDirection(): static;

    abstract public function isClockwise(): bool;

    abstract public function isCounterClockwise(): bool;
    
    /**
     * Return an array containing separate sexagesimal values.
     * 
     * The direction of the `Angle` is the sign of `"degrees"` value.
     *
     * @param bool $associative Set to true it returns an associative array.
     * @param int $precision The precision used for seconds.
     * @return array{int,int,float}|array{degrees:int,minutes:int,seconds:float}
     */
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
}