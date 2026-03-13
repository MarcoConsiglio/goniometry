<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\RelativeSum;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The RelativeSum SumBuilder")]
#[CoversClass(RelativeSum::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
class RelativeSumTest extends TestCase
{
    #[TestDox("can sum two Angles and return a positive sum.")]
    public function test_can_sum_angles_and_return_positive_sum(): void
    {
        // Arrange
        $alfa = $this->positiveRandomAngle();
        $beta = $this->positiveRandomAngle();
        $sum = 
            $alfa->toDecimal()->value
            ->plus($beta->toDecimal()->value)
            ->plus(Degrees::MAX);
        $expected_sum = new SexadecimalDegrees($sum);
        $gamma = Angle::createFromDecimal($expected_sum);

        // Act
        $actual_sum = new RelativeSum($alfa, $beta)->fetchData();

        // Assert
        $this->assertEquals($gamma->degrees->value, $actual_sum[0]->value);
        $this->assertEquals($gamma->minutes->value, $actual_sum[1]->value);
        $this->assertEquals($gamma->seconds->value, $actual_sum[2]->value);
        $this->assertEquals($gamma->direction, $actual_sum[3]);       
    }

    #[TestDox("can sum two Angles and return a negative sum.")]
    public function test_can_sum_angles_and_return_negative_sum(): void
    {
        // Arrange
        $alfa = $this->negativeRandomAngle();
        $beta = $this->negativeRandomAngle();
        $sum = 
            $alfa->toDecimal()->value
            ->plus($beta->toDecimal()->value)
            ->plus(Degrees::MAX);
        $expected_sum = new SexadecimalDegrees($sum);
        $gamma = Angle::createFromDecimal($expected_sum);

        // Act
        $actual_sum = new RelativeSum($alfa, $beta)->fetchData();

        // Assert
        $this->assertEquals($gamma->degrees->value, $actual_sum[0]->value);
        $this->assertEquals($gamma->minutes->value, $actual_sum[1]->value);
        $this->assertEquals($gamma->seconds->value, $actual_sum[2]->value);
        $this->assertEquals($gamma->direction, $actual_sum[3]);       
    }
}