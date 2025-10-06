<?php declare(strict_types=1);
namespace MarcoConsiglio\Goniometry;

use InvalidArgumentException;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use MarcoConsiglio\Goniometry\Interfaces\AngleBuilder;
use RoundingMode;

/**
 * Represents an angle.
 * 
 * @property-read int $degrees
 * @property-read int $minutes
 * @property-read float $seconds
 * @property-read int $direction
 */
class Angle implements AngleInterface
{
    /**
     * Regular expression used to parse degrees value.
     */
    public const DEGREES_REGEX = "/^(-?(?:360|3[0-5][[:digit:]]|[12]?[[:digit:]]{1,2}))°/";

    /**
     * Regular expression used to parse minutes value.
     */
    public const MINUTES_REGEX = '/\b([0-5]?[[:digit:]])\'/';

    /**
     * Regular expression used to parse second values.
     */
    public const SECONDS_REGEX = '/\b((?:[1-5]?[[:digit:]])(?:\.[[:digit:]])?)"$/';
   
    /**
     * It represents a negative angle.
     */
    public const CLOCKWISE = -1;

    /**
     * It represents a positive angle.
     */
    public const COUNTER_CLOCKWISE = 1;

    /**
     * The max degrees an angle can have.
     */
    public const MAX_DEGREES = 360;

    /**
     * The max minutes an angle can have.
     */
    public const MAX_MINUTES = 60;

    /**
     * The max seconds an angle can have.
     */
    public const MAX_SECONDS = 60;

    /**
     * Radian measure of a round angle.
     */
    public const MAX_RADIAN = 2 * M_PI;

    /**
     * The degrees part.
     *
     * @var integer
     */
    protected int $degrees;

    /**
     * The minutes part.
     *
     * @var integer
     */
    protected int $minutes;

    /**
     * The seconds part.
     *
     * @var integer
     */
    protected float $seconds;

    /** 
     * The angle direction.
     *  
     * self::COUNTERCLOCKWISE means positive angle.
     * self::CLOCKWISE means negative angle,
     */
    protected int $direction = Angle::COUNTER_CLOCKWISE;

    /**
     * Construct an angle.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\AngleBuilder $builder
     * @return void
     */
    public function __construct(AngleBuilder $builder)
    {
        [$this->degrees, $this->minutes, $this->seconds, $this->direction] = $builder->fetchData();
    }

    /**
     * Getters.
     *
     * @param string $property
     * @return mixed
     */
    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
     * Creates an angle from its values.
     *
     * @param integer $degrees
     * @param integer $minutes
     * @param float $seconds
     * @return Angle
     * @throws \MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException when creating an angle greater than 360°.
     */
    public static function createFromValues(int $degrees = 0, int $minutes = 0, float $seconds = 0.0, int $direction = self::COUNTER_CLOCKWISE): Angle
    {
        return new Angle(new FromDegrees($degrees, $minutes, $seconds, $direction));
    }

    /**
     * Creates an angle from its textual representation.
     *
     * @param string $angle
     * @return Angle
     * @throws \MarcoConsiglio\Goniometry\Exceptions\NoMatchException when $angle has no match.
     * @throws \MarcoConsiglio\Goniometry\Exceptions\RegExFailureException when there's a failure in regex parser engine.
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
     * @throws \MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException when creating an angle greater than 360°.
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
     * @throws \MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException when creating an angle greater than 360°.
     */
    public static function createFromRadian(float $radian): Angle
    {
         return new Angle(new FromRadian($radian));
    }

    /**
     * Return an array containing the values
     * of degrees, minutes and seconds.
     *
     * @param bool $associative Gets an associative array.
     * @return array
     */
    public function getDegrees(bool $associative = false): array
    {
        if ($associative) {
            return [
                "degrees" => $this->degrees * $this->direction,
                "minutes" => $this->minutes,
                "seconds" => $this->seconds
            ];
        } else {
            return [
                $this->degrees * $this->direction,
                $this->minutes,
                $this->seconds
            ];
        }
    }

    /**
     * Check if this angle is clockwise or negative.
     *
     * @return boolean
     */
    public function isClockwise(): bool
    {
        return $this->direction == self::CLOCKWISE;
    }

    /**
     * Check if this angle is counterclockwise or positive.
     *
     * @return boolean
     */
    public function isCounterClockwise(): bool
    {
        return $this->direction == self::COUNTER_CLOCKWISE;
    }

    /**
     * Reverse the direction of rotation.
     *
     * @return Angle
     */
    public function toggleDirection(): Angle
    {
        $this->direction *= self::CLOCKWISE;
        return $this;
    }

    /**
     * Gets the decimal degrees representation of this angle.
     *
     * @param integer $precision The number of decimal digits.
     * @return float The angular value expressed as a decimal number.
     */
    public function toDecimal(int $precision = 1): float
    {
        $decimal = round(
            $this->degrees + 
            $this->minutes / Angle::MAX_MINUTES + 
            $this->seconds / (Angle::MAX_MINUTES * Angle::MAX_SECONDS),
        $precision, RoundingMode::HalfTowardsZero);
        $decimal *= $this->direction;
        return $decimal;
    }

    /**
     * Gets the radian representation of this angle.
     *
     * @param integer $precision The number of decimal digits.
     * @return float The angular value expressed as a radian number.
     */
    public function toRadian(int $precision = 1): float
    {
        return round(deg2rad($this->toDecimal(15)), $precision, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Check if this angle is greater than $angle.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @param int $precision The precision digits with which to test the greater than comparison.
     * @return boolean True if this angle is greater than $angle, false otherwise.
     * @throws \TypeError when $angle has an unexpected type argument.
     * @throws \MarcoConsiglio\Goniometry\Exceptions\RegExFailureException when there's a failure in regex parser engine.
     */
    public function isGreaterThan(string|int|float|AngleInterface $angle, int $precision = 1): bool
    {
        if (is_string($angle)) {
            $angle = Angle::createFromString($angle);
            return abs($this->toDecimal($precision)) > abs($angle->toDecimal($precision));
        }
        if (is_int($angle)) {
            return abs($this->toDecimal(0)) > abs($angle);
        }
        if (is_float($angle)) {
            return abs($this->toDecimal($precision)) > abs(round($angle, $precision, RoundingMode::HalfTowardsZero));
        } 
        return abs($this->toDecimal($precision)) > abs($angle->toDecimal($precision));
    }

    /**
     * Alias of isGreaterThan method.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @param int $precision The precision digits with which to test the greater than comparison.
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type.
     */
    public function gt(string|int|float|AngleInterface $angle, int $precision = 1): bool
    {
        return $this->isGreaterThan($angle, $precision);
    }

    /**
     * Check if this angle is greater than or equal to $angle.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type.
     */
    public function isGreaterThanOrEqual(string|int|float|AngleInterface $angle, int $precision = 1): bool
    {
        return $this->isEqual($angle, $precision) || $this->isGreaterThan($angle, $precision);
    }

    /**
     * Alias of isGreaterThanOrEqual method.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type.
     */
    public function gte(string|int|float|AngleInterface $angle, int $precision = 1): bool
    {
        return $this->isGreaterThanOrEqual($angle, $precision);
    }

    /**
     * Check if this angle is less than another angle.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type.
     */
    public function isLessThan(string|int|float|AngleInterface $angle, int $precision = 1): bool
    {
        return !$this->isGreaterThanOrEqual($angle, $precision);
    }

    /**
     * Alias of isLessThan method.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type.
     */
    public function lt(string|int|float|AngleInterface $angle, int $precision = 1): bool
    {
        return $this->isLessThan($angle);
    }

    /**
     * Check if this angle is less than or equal to $angle.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type.
     */
    public function isLessThanOrEqual(string|int|float|AngleInterface $angle, int $precision = 1): bool
    {
        return $this->isEqual($angle, $precision) || $this->isLessThan($angle, $precision);
    }

    
    /**
     * Alias of isLessThanOrEqual method.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type.     
     * @throws \MarcoConsiglio\Goniometry\Exceptions\RegExFailureException when there's a failure in regex parser engine.
     */
    public function lte(string|int|float|AngleInterface $angle, int $precision = 1): bool
    {
        return $this->isLessThanOrEqual($angle);
    }

    /**
     * Check if this angle is equal to $angle.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle The angle expressed 
     * in a string, integer, float (degree, not radian) format or an instance of Angle.
     * @param int $precision The precision digits with which to test the equality
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type argument.
     * @throws \MarcoConsiglio\Goniometry\Exceptions\RegExFailureException when there's a failure in regex parser engine.
     */
    public function isEqual(string|int|float|AngleInterface $angle, int $precision = 1): bool
    {
        if (is_string($angle)) {
            $angle = Angle::createFromString($angle);
            return abs($this->toDecimal($precision)) == abs($angle->toDecimal($precision));
        }
        if (is_int($angle)) {
            return abs($this->toDecimal(0)) == abs($angle);
        }
        if (is_float($angle)) {
            return abs($this->toDecimal($precision)) == abs(round($angle, $precision, RoundingMode::HalfTowardsZero));
        }
        /** @var \MarcoConsiglio\Goniometry\Angle $angle */
        $equal_degrees = $this->degrees == $angle->degrees;
        $equal_minutes = $this->minutes == $angle->minutes;
        $equal_seconds = $this->seconds == $angle->seconds;
        return $equal_degrees && $equal_minutes && $equal_seconds;
    }

    /**
     * Alias of isEqual method.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @param int $precision The precision digits with which to test the equality.
     * @return boolean
     */
    public function eq(string|int|float|AngleInterface $angle, int $precision = 1): bool
    {
        return $this->isEqual($angle, $precision);
    }

    /**
     * Check if this angle is different than $angle
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @param integer $precision
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type argument.
     * @throws \MarcoConsiglio\Goniometry\Exceptions\RegExFailureException when there's a failure in regex parser engine.
     */
    public function isDifferent(string|int|float|AngleInterface $angle, int $precision = 1): bool
    {
        return !$this->isEqual($angle);
    }

    /**
     * Alias for isDifferent method.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @param integer $precision
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type argument.
     * @throws \MarcoConsiglio\Goniometry\Exceptions\RegExFailureException when there's a failure in regex parser engine.
     */
    public function not(string|int|float|AngleInterface $angle, $precision = 1): bool {
        return $this->isDifferent($angle, $precision);
    }

    /**
     * Get a textual representation of this angle in degrees.
     *
     * @return string
     */
    public function __toString()
    {
        $sign = $this->isClockwise() ? "-" : "";
        return "{$sign}{$this->degrees}° {$this->minutes}' {$this->seconds}\"";
    }

    /**
     * It calculates the total seconds that make up the $angle.
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @param int $precision The number of decimal digits.
     */
    static public function toTotalSeconds(AngleInterface $angle, int $precision = 1) {
        return round(
            $angle->seconds +
            $angle->minutes * Angle::MAX_SECONDS +
            $angle->degrees * Angle::MAX_SECONDS * Angle::MAX_MINUTES, 
            $precision, RoundingMode::HalfTowardsZero
        );
    }
}