<?php
namespace MarcoConsiglio\Goniometry\Tests;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\AngleBuilder;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Builders\FromString;
use Faker\Factory;
use Faker\Generator;
use MarcoConsiglio\Goniometry\Tests\Traits\WithFailureMessage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    use WithFailureMessage;
    
    /**
     * The faker generator.
     *
     * @var Generator;
     */
    protected Generator $faker;

    /**
     * This method is called before each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    /**
     * Gets a random angle.
     *
     * @param int $sign
     * @return \MarcoConsiglio\Goniometry\Angle
     */
    protected function getRandomAngle(bool $negative = false): \MarcoConsiglio\Goniometry\Angle
    {
        [$degrees, $minutes, $seconds] = $this->getRandomAngleValue(FromDegrees::class, $negative);
        if ($negative) {
            $negative = Angle::CLOCKWISE;
        } else {
            $negative = Angle::COUNTER_CLOCKWISE;
        }
        return Angle::createFromValues($degrees, $minutes, $seconds, $negative);
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
                    return $this->getRandomAngleDegrees($negative);
                    break;
                case FromDecimal::class:
                    return $this->getRandomAngleDecimal($negative, $precision);
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
     * Gets random sexage values.
     *
     * @param boolean $negative
     * @return array
     */
    protected function getRandomAngleDegrees($negative = false)
    {
        $degrees = $this->faker->numberBetween(0, 360);
        $minutes = $this->faker->numberBetween(0, 59);
        $seconds = $this->faker->randomFloat(
            $this->faker->numberBetween(0, PHP_FLOAT_DIG), 0, 59.9
        );
        return [$negative ? -$degrees : $degrees, $minutes, $seconds];
    }

    /**
     * Return a random sexadecimal value.
     *
     * @param boolean $negative If negative or positive number.
     * @param int|null $precision The precision digits of the result.
     * @return float
     */
    protected function getRandomAngleDecimal($negative = false, int|null $precision = null): float
    {
        return $negative ? 
            $this->faker->randomFloat($precision, 0, Angle::MAX_DEGREES) : 
            $this->faker->randomFloat($precision, -Angle::MAX_DEGREES, 0);
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
        [$degrees, $minutes, $seconds] = $this->getRandomAngleDegrees($negative);
        return "{$degrees}° {$minutes}' {$seconds}\"";
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
        if (!empty($mocked_methods)) {
            $angle->onlyMethods($mocked_methods);
        }
        if ($original_constructor) {
            $angle->enableOriginalConstructor()
                    ->setConstructorArgs(
                        is_array($constructor_arguments) ? $constructor_arguments : [$constructor_arguments]
                    );
        }
        return $angle->getMock();
    }

 }