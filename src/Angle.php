<?php 
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
     *  Angle regular expression used to parse degrees, minutes and seconds values.
     * @see https://regex101.com/r/OQCxIV/1
     * @deprecated
     */
    public const ANGLE_REGEX = '/^(?:(-?360(*ACCEPT))|(-?[1-3]?[0-9]?[0-9]?))°?\s?([0-5]?[0-9])?\'?\s?([0-5]?[0-9]?)?"?$/';

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
     * Creates an angle from its radiant representation.
     *
     * @param float $radiant
     * @return Angle
     * @throws \MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException when creating an angle greater than 360°.
     */
    public static function createFromRadian(float $radiant): Angle
    {
         return new Angle(new FromRadian($radiant));
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
     * Gets the radiant representation of this angle.
     *
     * @param integer $precision The number of decimal digits.
     * @return float The angular value expressed as a radiant number.
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
     * @throws \InvalidArgumentException when $angle has an unexpected type argument.
     * @throws \MarcoConsiglio\Goniometry\Exceptions\RegExFailureException when there's a failure in regex parser engine.
     */
    public function isGreaterThan($angle, int $precision = 1): bool
    {
        if (is_numeric($angle)) {
            return abs($this->toDecimal($precision)) > abs($angle);
        } elseif ($angle instanceof AngleInterface) {
            return abs($this->toDecimal($precision)) > abs($angle->toDecimal($precision));
        } elseif (is_string($angle)) {
            $angle = Angle::createFromString($angle);
            return abs($this->toDecimal($precision)) > abs($angle->toDecimal($precision));
        }
        // If the addend is of an invalid type, throws an exception.
        $this->throwInvalidArgumentException($angle, ["int", "float", "string", Angle::class], __METHOD__, 1);
        return false;
    }

    /**
     * Alias of isGreaterThan method.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @param int $precision The precision digits with which to test the greater than comparison.
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type.
     */
    public function gt($angle, int $precision = 1): bool
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
    public function isGreaterThanOrEqual($angle): bool
    {
        $is_string = is_string($angle);
        $is_numeric = is_numeric($angle);
        $is_object = $angle instanceof AngleInterface;
        if ($is_string or $is_numeric or $is_object) {
            if ($this->isEqual($angle)) {
                return true;
            }
            return $this->isGreaterThan($angle);
        }
        $this->throwInvalidArgumentException($angle, ["int", "float", "string", Angle::class], __METHOD__, 1);
        return false;
    }

    /**
     * Alias of isGreaterThanOrEqual method.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type.
     */
    public function gte($angle): bool
    {
        return $this->isGreaterThanOrEqual($angle);
    }

    /**
     * Check if this angle is less than another angle.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type.
     */
    public function isLessThan($angle): bool
    {
        if (is_numeric($angle)) {
            return abs($this->toDecimal()) < abs($angle);
        } elseif ($angle instanceof AngleInterface) {
            return abs($this->toDecimal()) < abs($angle->toDecimal());
        } elseif (is_string($angle)) {
            $angle = Angle::createFromString($angle);
            return abs($this->toDecimal()) < abs($angle->toDecimal());
        }
        $this->throwInvalidArgumentException($angle, ["int", "float", "string", Angle::class], __METHOD__, 1);
        return false;
    }

    /**
     * Alias of isLessThan method.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type.
     */
    public function lt($angle): bool
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
    public function isLessThanOrEqual($angle): bool
    {
        $is_string = is_string($angle);
        $is_numeric = is_numeric($angle);
        $is_object = $angle instanceof AngleInterface;
        if ($is_string or $is_numeric or $is_object) {
            if ($this->isEqual($angle)) {
                return true;
            }
            return $this->isLessThan($angle);
        }
        $this->throwInvalidArgumentException($angle, ["int", "float", "string", Angle::class], __METHOD__, 1);
        return false;
    }

    
    /**
     * Alias of isLessThanOrEqual method.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @return boolean
     * @throws \InvalidArgumentException when $angle has an unexpected type.
     */
    public function lte($angle): bool
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
    public function isEqual($angle, int $precision = 1): bool
    {
        if (is_numeric($angle)) {
            return abs($this->toDecimal($precision)) == abs($angle);
        }
        if ($angle instanceof AngleInterface) {
            /** @var \MarcoConsiglio\Goniometry\Angle $angle */
            $equal_degrees = $this->degrees == $angle->degrees;
            $equal_minutes = $this->minutes == $angle->minutes;
            $equal_seconds = $this->seconds == $angle->seconds;
            return $equal_degrees && $equal_minutes && $equal_seconds;
        } elseif (is_string($angle)) {
            $angle = Angle::createFromString($angle);
            return abs($this->toDecimal($precision)) == abs($angle->toDecimal($precision));
        }
        $this->throwInvalidArgumentException($angle, ["int", "float", "string", Angle::class], __METHOD__, 1);
        return false;
    }

    /**
     * Alias of isEqual method.
     *
     * @param string|int|float|\MarcoConsiglio\Goniometry\Interfaces\Angle $angle
     * @param int $precision The precision digits with which to test the equality.
     * @return boolean
     */
    public function eq($angle, int $precision = 1): bool
    {
        return $this->isEqual($angle, $precision);
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
     * Throws an InvalidArgumentException specifing the expected argument types and
     * the actual argument type.
     *
     * @param mixed   $argument The actual argument throwing the exception.
     * @param array   $expected_types A list of expected types.
     * @param string  $method The method throwing the exception. Use __METHOD__ constant as argument.
     * @param integer $parameter_position The parameter position.
     * @return void
     * @throws \InvalidArgumentException when calling this method.
     */
    private function throwInvalidArgumentException(mixed $argument, array $expected_types, string $method, int $parameter_position)
    {
        $last_type = "";
        $total_types = count($expected_types);
        if ($total_types >= 2) {
            $last_type = " or ".$expected_types[$total_types - 1];
            unset($expected_types[$total_types - 1]);
        }
        $message = "$method method expects parameter $parameter_position to be ".implode(", ", $expected_types).$last_type.", but found ".gettype($argument);
        throw new InvalidArgumentException($message);
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