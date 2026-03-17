<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\AbsoluteSum;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The AbsoluteSum SumBuilder")]
#[CoversClass(AbsoluteSum::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Direction::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class AbsoluteSumTest extends TestCase
{
    #[TestDox("can sum two Angles and return an absolute sum.")]
    public function test_can_sum_angles(): void
    {
        // Arrange
        $alfa = $this->randomAngle();
        $beta = $this->randomAngle();
        $sum = 
            $alfa->toSexadecimalDegrees()->value
            ->plus($beta->toSexadecimalDegrees()->value)
            ->plus(Degrees::MAX);
        $expected_sum = new SexadecimalDegrees($sum);
        $gamma = Angle::createFromDecimal($expected_sum);

        // Act
        $actual_sum = new AbsoluteSum($alfa, $beta)->fetchData();
        $sexagesimal = $actual_sum[0];

        // Assert
        $this->assertEquals($gamma->degrees->value(), $sexagesimal->degrees->value());
        $this->assertEquals($gamma->minutes->value(), $sexagesimal->minutes->value());
        $this->assertEquals($gamma->seconds->value(), $sexagesimal->seconds->value());
        $this->assertEquals($gamma->direction, $sexagesimal->direction);
    }
}