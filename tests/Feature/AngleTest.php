<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromAnglesToAbsoluteSum;
use MarcoConsiglio\Goniometry\Builders\FromAnglesToRelativeSum;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Builders\SumBuilder;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Angle class")]
#[CoversClass(Angle::class)]
#[UsesClass(FromAnglesToAbsoluteSum::class)]
#[UsesClass(FromAnglesToRelativeSum::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(SumBuilder::class)]
class AngleTest extends TestCase
{
    #[TestDox("can sum two angles obtaining a relative result.")]
    public function test_can_sum_two_angles_and_return_relative_result()
    {
        // Arrange
        $alfa = $this->getRandomAngle($this->faker->boolean);
        $beta = $this->getRandomAngle($this->faker->boolean);

        // Act
        $gamma = Angle::sum($alfa, $beta);

        // Assert
        $this->assertInstanceOf(Angle::class, $gamma, $this->methodMustReturn(
            Angle::class, "sum", Angle::class
        ));
    }

    #[TestDox("can sum two angles obtaining an absolute result.")]
    public function test_can_sum_two_angles_and_return_absolute_result()
    {
        // Arrange
        $alfa = $this->getRandomAngle($this->faker->boolean);
        $beta = $this->getRandomAngle($this->faker->boolean);

        // Act
        $gamma = Angle::absSum($alfa, $beta);

        // Assert
        $this->assertInstanceOf(Angle::class, $gamma, $this->methodMustReturn(
            Angle::class, "absSum", Angle::class
        ));
        $this->assertEquals(Angle::COUNTER_CLOCKWISE, $gamma->direction, 
            Angle::class."absSum() method must always return a positive angle."
        );
    }
}