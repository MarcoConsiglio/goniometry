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
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexagesimal as NegativeSexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexagesimal as PositiveSexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeRadian as RelativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexagesimal as RelativeSexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\MinutesRange;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeRadian as NegativeRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveRadian as PositiveRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;

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
    public function randomDegrees(int $min = 0, int $max = Degrees::MAX - 1): Degrees
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
    public function randomMinutes(int $min = 0, int $max = Minutes::MAX - 1): Minutes
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
    ): Seconds {
        return new SecondsGenerator(
            self::$faker,
            new SecondsValidator,
            new SecondsRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return a random Angle, whether positive or negative.
     */
    public function randomAngle(
        float $min = -Degrees::MAX, 
        float $max = Degrees::MAX,
        int $precision = PHP_FLOAT_DIG    
    ): Angle {
        return new RelativeAngleGenerator(
            self::$faker,
            new RelativeSexadecimalValidator,
            new SexadecimalRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return a positive random `Angle`.
     */
    public function positiveRandomAngle(
        float $min = 0.0, 
        float $max = Degrees::MAX, 
        int $precision = PHP_FLOAT_DIG
    ): Angle {
        return new PositiveAngleGenerator(
            self::$faker,
            new PositiveSexadecimalValidator,
            new SexadecimalRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return a negative random `Angle`.
     */
    public function negativeRandomAngle(
        float $min = -Degrees::MAX, 
        float $max = 0.0,
        int $precision = PHP_FLOAT_DIG
    ): Angle {
        return new NegativeAngleGenerator(
            self::$faker,
            new NegativeSexadecimalValidator,
            new SexadecimalRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return a random angle direction.
     */
    public function randomDirection(): Direction
    {
        return self::$faker->randomElement([
            Direction::COUNTER_CLOCKWISE,
            Direction::CLOCKWISE
        ]);
    }

    /**
     * Returns a random angle string.
     */
    public function randomSexagesimalString(
        float $min = -Degrees::MAX, 
        float $max = Degrees::MAX,
        int $precision = PHP_FLOAT_DIG
    ) {
        $sexagesimal_values = new RelativeSexagesimalGenerator(
            self::$faker,
            new RelativeSexadecimalValidator,
            new SexadecimalRange($min, $max)
        )->generate($precision);
        return "{$sexagesimal_values}";
    }

    /**
     * Return random sexagesimal values.
     */
    public function randomSexagesimal(
        float $min = -Degrees::MAX,
        float $max = Degrees::MAX,
        int $precision = PHP_FLOAT_DIG
    ): SexagesimalDegrees {
        return new RelativeSexagesimalGenerator(
            self::$faker,
            new RelativeSexadecimalValidator,
            new SexadecimalRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return random sexagesimal values from a positive `Angle`.
     */
    public function positiveRandomSexagesimal(
        float $min = 0.0, 
        float $max = Degrees::MAX, 
        int $precision = PHP_FLOAT_DIG
    ): SexagesimalDegrees {
        return new PositiveSexagesimalGenerator(
            self::$faker,
            new PositiveSexadecimalValidator,
            new SexadecimalRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return random sexagesimal values for a negative Angle.
     */
    public function negativeRandomSexagesimal(
        float $min = -Degrees::MAX,
        float $max = 0.0,
        int $precision = PHP_FLOAT_DIG
    ): SexagesimalDegrees {
        return new NegativeSexagesimalGenerator(
            self::$faker,
            new NegativeSexadecimalValidator,
            new SexadecimalRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return a random sexadecimal value, from 0° to 360°,
     * excluded 360°.
     */
    public function randomSexadecimal(
        float $min = -Degrees::MAX, 
        float $max = Degrees::MAX, 
        int $precision = PHP_FLOAT_DIG
    ): float {
        return new RelativeSexadecimalGenerator(
            self::$faker,
            new RelativeSexadecimalValidator,
            new SexadecimalRange($min, $max)
        )->generate($precision);
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
        float $max = Degrees::MAX, 
        int $precision = PHP_FLOAT_DIG
    ): float {
        return new NegativeSexadecimalGenerator(
            self::$faker,
            new NegativeSexadecimalValidator,
            new SexadecimalRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return a random relative radian value.
     */
    public function randomRadian(
        float $min = -Radian::MAX, 
        float $max = Radian::MAX,
        int $precision = PHP_FLOAT_DIG
    ): Radian {
        return new RelativeRadianGenerator(
            self::$faker,
            new RelativeRadianValidator,
            new RadianRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return a positive random radian value.
     */
    public function positiveRandomRadian(
        float $min = 0, 
        float $max = Radian::MAX,
        int $precision = PHP_FLOAT_DIG
    ): Radian {
        return new PositiveRadianGenerator(
            self::$faker,
            new PositiveRadianValidator,
            new RadianRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return a negative random radian value.
     */
    public function negativeRandomRadian(
        float $min = -Radian::MAX, 
        float $max = 0,
        int $precision = PHP_FLOAT_DIG
    ): Radian {
        return new NegativeRadianGenerator(
            self::$faker,
            new NegativeRadianValidator,
            new RadianRange($min, $max)
        )->generate($precision);
    }
}