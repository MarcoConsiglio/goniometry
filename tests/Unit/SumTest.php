<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromAngles;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\SumBuilder;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use MarcoConsiglio\Goniometry\Operations\Sum;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;

#[TestDox("A sum operation")]
#[CoversClass(Sum::class)]
#[CoversClass(SumBuilder::class)]
class SumTest extends TestCase
{
    #[TestDox("can be performed with a SumBuilder.")]
    public function test_can_sum_two_angle()
    {
        // Arrange
        $values = $this->getRandomAngleDegrees($this->faker->boolean());
        $values[3] = $values[0] < 0 ? Angle::COUNTER_CLOCKWISE : Angle::CLOCKWISE;
        $values[0] = abs($values[0]);
        $builder = $this->getMockBuilder(FromAngles::class)
            ->onlyMethods(["fetchData"])
            ->disableOriginalConstructor()
            ->getMock();
        $builder->expects($this->once())->method("fetchData")->willReturn($values);

        // Act
        /** @var \MarcoConsiglio\Goniometry\Builders\FromAngles $builder */
        $sum = new Sum($builder);

        // Assert
        $this->assertInstanceOf(Sum::class, $sum, "The sum must be a Sum class.");
        $this->assertInstanceOf(Angle::class, $sum, "The sum must extend the Angle class.");
    }
}