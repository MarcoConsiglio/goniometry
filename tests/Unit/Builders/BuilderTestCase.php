<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\AngleBuilder;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Enums\Direction;
use Marcoconsiglio\ModularArithmetic\ModularNumber;
use PHPUnit\Framework\MockObject\MockObject;
use RoundingMode;

/**
 * Supportive class for testing Builders.
 */
abstract class BuilderTestCase extends TestCase
{
    /**
     * Expects an $exception with a $message.
     * It is a Custom Assertion.
     *
     * @param string $exception
     * @param string $message
     * @return void
     */
    protected function expectExceptionWithMessage(string $exception, string $message): void
    {
        $this->expectException($exception);
        $this->expectExceptionMessage($message);
    }

    /**
     * Test the Angle creation with a specified AngleBuilder. 
     * This is a Parameterized Test.
     *
     * @param mixed   $value   The value used to create the angle.
     * @param string  $builder The builder that extends AngleBuilder.
     * @param boolean $negative Specifies if to test a negative angle.
     * @param int|null $precision The precision if the angle is created from a decimal or radian value.
     * @return void
     */
    protected function testAngleCreation(string $builder, bool $negative = false, int|null $precision = null)
    {
        if(class_exists($builder) && is_subclass_of($builder, AngleBuilder::class)) {
            // Arrange
            $value = $this->getRandomAngleValue($builder, $negative, $precision);
            
            // Act
            switch ($builder) {
                case FromDegrees::class:
                    $angle = Angle::createFromValues(
                        $value[0], /* Degrees */
                        $value[1], /* Minutes */
                        $value[2], /* Seconds */
                        $value[3]  /* Sign */
                    );
                    break;
                case FromDecimal::class:
                    $angle = Angle::createFromDecimal($value);
                    break;
                case FromRadian::class:
                    $angle = Angle::createFromRadian($value);
                    break;
                case FromString::class:
                    $angle = Angle::createFromString($value);
                    break;
            }

            // Assert
            $this->assertAngle($builder, $value, $angle);
        }
    }

    /**
     * Assert that an $object property $name equals $expected_value and its type is $expected_type.
     *
     * @param string $expected_type The type you expect from the property.
     * @param string $name  The name of the property.
     * @param object $object    The object to test.
     * @param mixed  $expected_value The value you expect from the property.
     * @return void
     */
    public function assertProperty(string $expected_type, string $name, object $object, mixed $expected_value)
    {
        $this->assertEquals($expected_value, $object->$name, $this->getterFail($name));
        if (class_exists($expected_type)) {
            $this->assertInstanceOf($expected_type, $object, $this->typeFail($name));
        }
        if ($expected_type == "int") {
            $this->assertIsInt($object->$name, $this->typeFail($name));
        }
        if ($expected_type == "float") {
            $this->assertIsFloat($object->$name, $this->typeFail($name));
        }
        if ($expected_type == "string") {
            $this->assertIsString($object->$name, $this->typeFail($name));
        }
        if ($expected_type == "boolean") {
            $this->assertIsBool($object->$name, $this->typeFail($name));
        }
    }

    /**
     * Assert that $angle has the $expected_values.
     *
     * @param array                              $values
     * @param \MarcoConsiglio\Goniometry\Angle $angle
     * @return void
     */
    public function assertAngleDegrees(array $expected_values, Angle $angle)
    {
        $this->assertProperty(ModularNumber::class, "degrees", $angle, abs($expected_values[0]));
        $this->assertProperty(ModularNumber::class, "minutes", $angle, $expected_values[1]);
        $this->assertProperty(ModularNumber::class, "seconds", $angle, $expected_values[2]);
        $this->assertProperty(Direction::class, "direction", $angle, $expected_values[3]);
    }

    /**
     * Assert that $angle->toFloat() equals $expected_values.
     *
     * @param float                              $expected_value The decimal value you expect from the $angle.
     * @param \MarcoConsiglio\Goniometry\Angle $angle The angle to test.
     * @return void
     */
    public function assertAngleDecimal(float $expected_value, Angle $angle)
    {
        $expected = $expected_value;
        $actual = $angle->toFloat();
        $angle_class = Angle::class;
        $this->assertEquals($expected, $actual, 
            "{$angle_class}::toFloat() should return {$expected} but found {$actual}."
        );
    }

    /**
     * Assert that $angle->toRadian() equals $expected_values.
     *
     * @param float                              $expected_value The radian value you expect from the $angle.
     * @param \MarcoConsiglio\Goniometry\Angle $angle The angle to test.
     * @return void
     */
    public function assertAngleRadian(float $expected_value, Angle $angle, $failure_message = "")
    {
        $expected = round($expected_value, 1, RoundingMode::HalfTowardsZero);
        $actual = round($angle->toRadian(), 1, RoundingMode::HalfTowardsZero);
        $angle_class = Angle::class;
        $this->assertEquals($expected, $actual, 
            "{$angle_class}::toRadian() should return {$expected} but found {$actual}."
        );
    }

    /**
     * Assert that $angle->__toString() equals $expected_value.
     *
     * @param string                             $expected_value The string value you expect from the $angle.
     * @param \MarcoConsiglio\Goniometry\Angle $angle The angle to test.
     * @return void
     */
    public function assertAngleString(string $expected_value, Angle $angle, $failure_message = "")
    {
        $angle_class = Angle::class;
        $actual = $angle->__toString();
        $this->assertEquals($expected_value, $actual, 
            "{$angle_class}::__toString() should return {$expected_value} but found {$actual}."
        );
    }

    /**
     * Assert that an $angle equals the $expected_value(s).
     * This is a Custom Assertion.
     *
     * @param string                             $builder
     * @param mixed                              $expected_value
     * @param \MarcoConsiglio\Goniometry\Angle $angle
     * @param string                             $failure_message
     * @return void
     */
    public function assertAngle(string $builder, mixed $expected_value, Angle $angle, string $failure_message = "")
    {
        switch ($builder) {
            case FromDegrees::class:
                $this->assertAngleDegrees($expected_value, $angle, $failure_message);
                break;
            case FromDecimal::class:
                $this->assertAngleDecimal($expected_value, $angle, $failure_message);
                break;
            case FromRadian::class:
                $this->assertAngleRadian($expected_value, $angle, $failure_message);
                break;
            case FromString::class:
                $this->assertAngleString($expected_value, $angle, $failure_message);
                break;
        }
    }

    /**
     * Constructs a mocked AngleBuilder based on the getBuilderClass method.
     *
     * @param array $mocked_methods The methods you want to hide or mock.
     * @param boolean $original_constructor Wheater you want to enable the original class constructor or a mocked one.
     * @param mixed $constructor_arguments If $oroginal_constructor = true pass here the constructor arguments.
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getMockedAngleBuilder(array $mocked_methods = [], $original_constructor = false, mixed $constructor_arguments = []): MockObject
    {
        $angle_builder = $this->getMockBuilder($this->getBuilderClass())
                        ->disableOriginalConstructor();
        if (!empty($mocked_methods)) {
            $angle_builder->onlyMethods($mocked_methods);
        }
        if ($original_constructor) {
            $angle_builder->enableOriginalConstructor()
                    ->setConstructorArgs(is_array($constructor_arguments) ? $constructor_arguments : [$constructor_arguments]);
        }
        return $angle_builder->getMock();
    }

    /**
     * Implemented in a concrete BuilderTestCase, returns the
     * concrete AngleBuilder class to test.
     * 
     * @return string
     */
    protected abstract function getBuilderClass(): string;
}