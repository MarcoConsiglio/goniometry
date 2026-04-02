<?php
namespace MarcoConsiglio\Goniometry\Traits;

use Deprecated;
use MarcoConsiglio\FakerPhpNumberHelpers\WithFakerHelpers;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\DegreesRange;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\MinutesRange;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;

/**
 * Provides support for FakerPHP in order to generate
 * random angular values.
 */
trait WithAngleFaker
{
    use WithFakerHelpers;
    
    /**
     * The Smallest Significant Number.
     */
    #[Deprecated("use NextFloat class instead", "v3.1.1")]
    public const float SSN = 0.0000000000001;

    /**
     * Return a random integer to be used as `float` rounding precision between
     * 0 and PHP_FLOAT_DIG. 
     */
    public function randomPrecision(): int
    {
        return $this->positiveRandomInteger(0, PHP_FLOAT_DIG);
    }

    /**
     * Return a random degrees value.
     */
    public function randomDegrees(int $min = 0, int $max = Degrees::MAX - 1): int
    {
        return new DegreesGenerator(
            self::$faker,
            new DegreesValidator,
            new DegreesRange($min, $max)
        )->generate();
    }

    /**
     * Return a random minutes value.
     */
    public function randomMinutes(int $min = 0, int $max = Minutes::MAX - 1): int
    {
        return new MinutesGenerator(
            self::$faker,
            new MinutesValidator,
            new MinutesRange($min, $max)
        )->generate();
    }

    /**
     * Return a random seconds value.
     */
    public function randomSeconds(
        float $min = 0, 
        float $max = Seconds::MAX, 
        int $precision = PHP_FLOAT_DIG
    ): float {
        return new SecondsGenerator(
            self::$faker,
            new SecondsValidator,
            new SecondsRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return a random Angle, whether positive or negative.
     */
    public function randomAngle(float $min = 0, float $max = Degrees::MAX): Angle
    {
        return $this->faker->randomElement([
            $this->positiveRandomAngle($min, $max),
            $this->negativeRandomAngle($min, $max)
        ]);
    }

    /**
     * Return a positive random Angle.
     */
    public function positiveRandomAngle(float $min = 0, float $max = Degrees::MAX - self::SSN): Angle
    {
        assert($min >= 0 && $min < Degrees::MAX);
        assert($max >= 0 && $max < Degrees::MAX);
        return Angle::createFromDecimal($this->positiveRandomSexadecimal($min, $max));
    }

    /**
     * Return a negative random Angle
     */
    public function negativeRandomAngle(float $min = 0, float $max = Degrees::MAX - self::SSN): Angle
    {
        $angle = $this->positiveRandomAngle($min, $max);
        return $angle->toggleDirection();
    }

    /**
     * Return a random angle direction.
     */
    public function randomDirection(): Direction
    {
        return $this->faker->randomElement([
            Direction::COUNTER_CLOCKWISE,
            Direction::CLOCKWISE
        ]);
    }

    /**
     * Returns a random angle string.
     */
    public function randomSexagesimalString(Direction $direction = Direction::COUNTER_CLOCKWISE)
    {
        [$degrees, $minutes, $seconds, $direction] = 
            $this->randomSexagesimal($direction);
        $sign = $direction == Direction::COUNTER_CLOCKWISE ? "" : "-";
        return "{$sign}{$degrees}° {$minutes}' {$seconds}\"";
    }

    /**
     * Return random sexagesimal values.
     *
     * @return array{int,int,float,Direction}
     */
    public function randomSexagesimal(Direction|null $direction = null)
    {
        if ($direction === null) $direction = $this->faker->randomElement([
            Direction::COUNTER_CLOCKWISE, Direction::CLOCKWISE
        ]);
        return [
            $this->randomDegrees(), 
            $this->randomMinutes(), 
            $this->randomSeconds(), 
            $direction
        ];
    }

    /**
     * Return random sexagesimal values for a positive Angle.
     * 
     * @return array{int,int,float,Direction::COUNTER_CLOCKWISE}
     */
    public function positiveRandomSexagesimal(): array
    {
        return $this->randomSexagesimal(Direction::COUNTER_CLOCKWISE);
    }

    /**
     * Return random sexagesimal values for a negative Angle.
     * 
     * @return array{int,int,float,Direction::CLOCKWISE}
     */
    public function negativeRandomSexagesimal(): array
    {
        return $this->randomSexagesimal(Direction::CLOCKWISE);
    }

    /**
     * Return a random sexadecimal value, from 0° to 360°,
     * excluded 360°.
     */
    public function randomSexadecimal(
        float $min = 0.0, 
        float $max = Degrees::MAX - self::SSN, 
        int $precision = PHP_FLOAT_DIG
    ): float {
        $random_value = $this->positiveRandomSexadecimal($min, $max, $precision);
        return $this->faker->randomElement([$random_value, -$random_value]);
    }

    /**
     * Return a random poisitve sexadecimal value, from 0° to 360°,
     * excluded 360°.
     */
    public function positiveRandomSexadecimal(
        float $min = 0.0, 
        float $max = Degrees::MAX, 
        int $precision = PHP_FLOAT_DIG
    ): float {
        return new PositiveSexadecimalGenerator(
            self::$faker,
            new PositiveSexadecimalValidator,
            new SexadecimalRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return a random negative sexadecimal value, from 0° to 360°,
     * excluded 360°.
     */
    public function negativeRandomSexadecimal(
        float $min = 0.0, 
        float $max = Degrees::MAX - self::SSN, 
        int $precision = PHP_FLOAT_DIG
    ): float {
        return -$this->positiveRandomSexadecimal($min, $max, $precision);
    }

    /**
     * Return a random relative radian value.
     */
    public function randomRadian(
        float $min = 0, 
        float $max = Radian::MAX - self::SSN,
        int $precision = PHP_FLOAT_DIG
    ): float {
        $radian = $this->positiveRandomRadian($min, $max, $precision);
        return $this->faker->randomElement([$radian, -$radian]);
    }

    /**
     * Return a positive random radian value.
     */
    public function positiveRandomRadian(
        float $min = 0, 
        float $max = Radian::MAX - self::SSN,
        int $precision = PHP_FLOAT_DIG
    ): float {
        return $this->positiveRandomFloat($min, $max, $precision);
    }

    /**
     * Return a negative random radian value.
     */
    public function negativeRandomRadian(
        float $min = 0, 
        float $max = Radian::MAX - self::SSN,
        int $precision = PHP_FLOAT_DIG
    ): float {
        return -$this->positiveRandomRadian($min, $max, $precision);
    }
}