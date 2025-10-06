<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The FromRadian builder")]
#[CoversClass(FromRadian::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleOverflowException::class)]
#[UsesClass(FromDecimal::class)]
class FromRadianTest extends BuilderTestCase
{
    #[TestDox("can create a positive angle from a radian value.")]
    public function test_can_create_positive_angle()
    {
        $this->testAngleCreation(FromRadian::class);
    }

    #[TestDox("can create a negative angle from a radian value.")]
    public function test_can_create_negative_angle()
    {
        $this->testAngleCreation(FromRadian::class, negative: true);
    }

    #[TestDox("cannot create an angle with more than +/-360°.")]
    public function test_exception_if_more_than_360_degrees()
    {
        // Assert
        $this->expectException(AngleOverflowException::class);
        $this->expectExceptionMessage("The angle can't be greater than +/-360°.");

        // Arrange & Act
        new FromRadian(Angle::MAX_RADIAN + 0.00001);
    }

    public function test_missing_exception_if_equal_360_degrees()
    {
        // Arrange & Act
        new FromRadian(Angle::MAX_RADIAN);

        // Assert
        $this->expectNotToPerformAssertions();
    }

    /**
     * Returns the FromRadian builder class.
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromRadian::class;
    }
}