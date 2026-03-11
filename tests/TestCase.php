<?php
namespace MarcoConsiglio\Goniometry\Tests;

use BcMath\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\AngleBuilder;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\FakerPhpNumberHelpers\WithFakerHelpers;
use MarcoConsiglio\Goniometry\Comparisons\Types\InputType;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\Traits\WithFailureMessage;
use Marcoconsiglio\ModularArithmetic\ModularNumber;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use ValueError;

class TestCase extends PHPUnitTestCase
{
    use WithFailureMessage, WithFakerHelpers;

    /**
     * The Smallest Significant Number.
     */
    protected const float SSN = 0.0000000000001;

    /**
     * This method is called before each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
    }

    /**
     * Constructs a mocked Angle.
     *
     * @param array $mocked_methods
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getMockedAngle(
        array $mocked_methods = [], 
        bool $original_constructor = false, 
        mixed $constructor_arguments = []
    ): MockObject
    {
        $angle = $this->getMockBuilder(Angle::class)
            ->disableOriginalConstructor();
        if (! empty($mocked_methods))
            $angle->onlyMethods($mocked_methods);
        if ($original_constructor) {
            $angle->enableOriginalConstructor()
                  ->setConstructorArgs(
                    is_array($constructor_arguments) ? $constructor_arguments : [$constructor_arguments]
                  );
        }
        return $angle->getMock();
    }

    protected function getMockedInputType(
        string $input_type,
        array $mocked_methods = [],
        bool $original_constructor = false,
        mixed $constructor_arguments = []
    ): MockObject
    {
        if (! class_exists($input_type)) 
            throw new ValueError("The class $input_type does not exists.");
        if (! is_subclass_of($input_type, InputType::class)) 
            throw new ValueError("The class $input_type is not a child of " . InputType::class . ".");
        $input_type = $this->getMockBuilder($input_type)
            ->disableOriginalConstructor();
        if (! empty($mocked_methods))
            $input_type->onlyMethods($mocked_methods);
        if ($original_constructor) {
            $input_type->enableOriginalConstructor()
                       ->setConstructorArgs(
                            is_array($constructor_arguments) ? $constructor_arguments : [$constructor_arguments]
                       );
        }
        return $input_type->getMock();
    }

    /**
     * Return a random integer to be used as rounding precision between
     * 0 and PHP_FLOAT_DIG. 
     */
    protected function randomPrecision(): int
    {
        return $this->positiveRandomInteger(0, PHP_FLOAT_DIG);
    }

    /**
     * Return a random Angle, whether positive or negative.
     */
    protected function randomAngle(float $min = 0, float $max = Degrees::MAX - self::SSN): Angle
    {
        return $this->faker->randomElement([
            $this->positiveRandomAngle($min, $max),
            $this->negativeRandomAngle($min, $max)
        ]);
    }

    /**
     * Return a positive random Angle.
     */
    protected function positiveRandomAngle(float $min = 0, float $max = Degrees::MAX - self::SSN): Angle
    {
        assert($min >= 0 && $min < Degrees::MAX);
        assert($max >= 0 && $max < Degrees::MAX);
        return Angle::createFromDecimal($this->positiveRandomSexadecimal($min, $max));
    }

    /**
     * Return a negative random Angle
     */
    protected function negativeRandomAngle(float $min = 0, float $max = Degrees::MAX - self::SSN): Angle
    {
        $angle = $this->positiveRandomAngle($min, $max);
        return $angle->toggleDirection();
    }

    /**
     * Returns a random angle measure (or an array with degrees, minutes and seconds values) 
     * usufull to create an angle from a specified $builder.
     *
     * @param string  $builder The builder class extending the `AngleBuilder`.
     *  you want to use to build the angle.
     * @param boolean $negative If you want a positive or negative angle.
     * @param int|null $precision The precision if the angle is created from a decimal or radian value.
     * @return mixed
     */
    protected function getRandomAngleValue(string $builder, $negative = false, int|null $precision = null): mixed
    {
        if (class_exists($builder) && is_subclass_of($builder, AngleBuilder::class)) {
            switch ($builder) {
                case FromDegrees::class:
                    return $this->randomSexagesimal($negative ? Direction::CLOCKWISE : Direction::COUNTER_CLOCKWISE);
                    break;
                case FromDecimal::class:
                    return $negative ? -$this->randomSexadecimal($precision) : $this->randomSexadecimal($precision);
                    break;
                case FromRadian::class:
                    return $this->getRandomAngleRadian($negative, $precision);
                    break;
                case FromString::class:
                    return $this->getRandomAngleString($negative);
                    break;
            }
        }
        return null;
    }

    /**
     * Return random sexagesimal values.
     *
     * @return array{int,int,float,Direction}
     */
    protected function randomSexagesimal(Direction|null $direction = null)
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
    protected function positiveRandomSexagesimal(): array
    {
        return $this->randomSexagesimal(Direction::COUNTER_CLOCKWISE);
    }

    /**
     * Return random sexagesimal values for a negative Angle.
     * 
     * @return array{int,int,float,Direction::CLOCKWISE}
     */
    protected function negativeRandomSexagesimal(): array
    {
        return $this->randomSexagesimal(Direction::CLOCKWISE);
    }



    /**
     * Return a random sexadecimal value.
     *
     * @param boolean $negative If negative or positive number.
     * @param int|null $precision The precision digits of the result.
     * @return float
     * @deprecated Use `randomSexadecimal()` instead.
     */
    protected function getRandomAngleDecimal($negative = false, int|null $precision = null): float
    {
        return $negative ? 
            -$this->getRandomPositiveAngleDecimal(min: 0 + PHP_FLOAT_MIN, precision: $precision) :
            $this->getRandomPositiveAngleDecimal(precision: $precision);
    }

    /**
     * Return a random positive sexadecimal value.
     * 
     * @deprecated Use positiveRandomSexadecimal() instead.
     */
    protected function getRandomPositiveAngleDecimal(
        float $min = 0, 
        float $max = Degrees::MAX - PHP_FLOAT_MIN, 
        int|null $precision = null
    ): float {
        if ($min < 0) $min = abs($min);
        if ($max < 0) $max = abs($max);
        if ($min > Degrees::MAX) $min = Degrees::MAX - PHP_FLOAT_MIN;
        if ($max > Degrees::MAX) $max = Degrees::MAX - PHP_FLOAT_MIN;
        return $this->positiveRandomFloat($min, $max, $precision);
    }

    /**
     * Returns a random radian value.
     *
     * @param boolean $negative
     * @param int|null $precision
     * @return void
     */
    protected function getRandomAngleRadian($negative = false, int|null $precision = null)
    {
        return $negative ? 
            $this->faker->randomFloat($precision, -Angle::MAX_RADIAN, 0):
            $this->faker->randomFloat($precision, 0, Angle::MAX_RADIAN); 
    }

    /**
     * Returns a random angle string.
     */
    protected function getRandomAngleString($negative = false)
    {
        [$degrees, $minutes, $seconds, $direction] = $this->randomSexagesimal(
            $negative ? Direction::CLOCKWISE : Direction::COUNTER_CLOCKWISE
        );
        $sign = $direction == Direction::COUNTER_CLOCKWISE ? "" : "-";
        return "{$sign}{$degrees}° {$minutes}' {$seconds}\"";
    }

    /**
     * Return a random degrees value.
     */
    protected function randomDegrees(int $min = 0, int $max = Degrees::MAX - 1): int
    {
        if ($min < 0 ) $min = abs($min);
        if ($min >= Degrees::MAX) $min = Degrees::MAX - 1;
        if ($max < 0) $max = abs($max);
        if ($max >= Degrees::MAX) $max = Degrees::MAX - 1;
        return $this->positiveRandomInteger($min, $max); 
    }

    /**
     * Return a random minutes value.
     */
    protected function randomMinutes(int $min = 0, int $max = Minutes::MAX - 1): int
    {
        if ($min < 0 ) $min = abs($min);
        if ($min >= Minutes::MAX) $min = Minutes::MAX - 1;
        if ($max < 0) $max = abs($max);
        if ($max >= Minutes::MAX) $max = Minutes::MAX - 1;
        return $this->positiveRandomInteger($min, $max);
    }

    /**
     * Return a random seconds value.
     */
    protected function randomSeconds(
        float $min = 0, 
        float $max = Seconds::MAX - self::SSN, 
        int $precision = PHP_FLOAT_DIG
    ): float {
        if ($min < 0 ) $min = abs($min);
        if ($min >= Seconds::MAX) $min = Seconds::MAX - self::SSN;
        if ($max < 0) $max = abs($max);
        if ($max >= Seconds::MAX) $max = Seconds::MAX - self::SSN;
        if ($precision < 0) $precision = abs($precision);
        if ($precision > PHP_FLOAT_DIG) $precision = PHP_FLOAT_DIG;
        return $this->positiveRandomFloat($min, $max, $precision);
    }

    /**
     * Return a random angle direction.
     */
    protected function randomDirection(): Direction
    {
        return $this->faker->randomElement([
            Direction::COUNTER_CLOCKWISE,
            Direction::CLOCKWISE
        ]);
    }

    /**
     * Return a random sexadecimal value, from 0° to 360°,
     * excluded 360°.
     */
    protected function randomSexadecimal(
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
    protected function positiveRandomSexadecimal(
        float $min = 0.0, 
        float $max = Degrees::MAX - self::SSN, 
        int $precision = PHP_FLOAT_DIG
    ): float {
        $min = abs($min); $max = abs($max); $precision = abs($precision);
        if ($min > Degrees::MAX) $min = Degrees::MAX - self::SSN;
        if ($max > Degrees::MAX) $max = Degrees::MAX - self::SSN;
        if ($precision > PHP_FLOAT_DIG) $precision = PHP_FLOAT_DIG;
        return $this->positiveRandomFloat($min, $max, $precision);
    }

    /**
     * Return a random negative sexadecimal value, from 0° to 360°,
     * excluded 360°.
     */
    protected function negativeRandomSexadecimal(
        float $min = 0.0, 
        float $max = Degrees::MAX - self::SSN, 
        int $precision = PHP_FLOAT_DIG
    ): float {
        return -$this->positiveRandomSexadecimal($min, $max, $precision);
    }

    /**
     * Convert a `$sexadecimal` value to sexagesimal values.
     * 
     * @return array{int,int,string,Direction} Return degrees, minutes, seconds
     * and direction. The seconds value is returned as a string specifically to
     * maintain precision. If necessary, convert it to a float yourself.
     */
    protected function toSexagesimal(float $sexadecimal): array
    {
        $direction = $sexadecimal >= 0 ? Direction::COUNTER_CLOCKWISE : Direction::CLOCKWISE;
        $sexadecimal = new ModularNumber(abs($sexadecimal), Degrees::MAX)->value;
        $degrees = intval($sexadecimal->floor()->value);
        $sexadecimal = $sexadecimal->sub($degrees);
        $minutes = intval($sexadecimal->mul(Minutes::MAX)->value);
        $sexadecimal = $sexadecimal->mul(Minutes::MAX)->sub($minutes);
        $seconds = $sexadecimal->mul(Seconds::MAX)->value;
        return [$degrees, $minutes, $seconds, $direction];
    }

    /**
     * Return a random relative radian value.
     */
    protected function randomRadian(
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
    protected function positiveRandomRadian(
        float $min = 0, 
        float $max = Radian::MAX - self::SSN,
        int $precision = PHP_FLOAT_DIG
    ): float {
        return $this->positiveRandomFloat($min, $max, $precision);
    }

    /**
     * Return a negative random radian value.
     */
    protected function negativeRandomRadian(
        float $min = 0, 
        float $max = Radian::MAX - self::SSN,
        int $precision = PHP_FLOAT_DIG
    ): float {
        return -$this->positiveRandomRadian($min, $max, $precision);
    }

    /**
     * Assert the passed $values are the same of $angle. 
     * This is a Custom Assertion.
    *
    * @param Angle $angle The angle being tested.
    * @param array $expected_values The expected values of the angle.
    * @return void
    */
    protected function assertAngleHasValues(Angle $angle, array $expected_values)
    {
        $values = $angle->getDegrees(true);
        $this->assertEquals($expected_values["degrees"], $values["degrees"]);
        $this->assertEquals($expected_values["minutes"], $values["minutes"]);
        $this->assertEquals($expected_values["seconds"], $values["seconds"]);
    }

 }