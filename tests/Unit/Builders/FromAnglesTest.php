<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Operations\Sum;
use MarcoConsiglio\Goniometry\Builders\FromAngles;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use RoundingMode;

#[TestDox("The FromAngles builder")]
#[CoversClass(FromAngles::class)]
#[CoversClass(Sum::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(FromDecimal::class)]
class FromAnglesTest extends BuilderTestCase
{
    #[TestDox("can sums two angles.")]
    public function test_can_sum_two_angle()
    {
        // Arrange
        $alfa = $this->getRandomAngle();
        $beta = $this->getRandomAngle();
        $builder = new FromAngles($alfa, $beta);
        $decimal_alfa = $alfa->toDecimal(3);
        $decimal_beta = $beta->toDecimal(3);

        // Act
        $result = $builder->fetchData();

        // Assert
        $gamma = Angle::createFromValues($result[0], $result[1], $result[2], $result[3]);
        $decimal_gamma = $gamma->toDecimal();
        $sum = round($decimal_alfa + $decimal_beta, 3, RoundingMode::HalfTowardsZero);
        if ($sum < 360 || $sum > 360) {
            if ($sum < 360) $sum = round($sum + 360, 3, RoundingMode::HalfTowardsZero);
            if ($sum > 360) $sum = round($sum - 360, 3, RoundingMode::HalfTowardsZero);
        }
        $sum = round($sum, 1);
        $failure_message = "{$decimal_alfa}° + {$decimal_beta}° must be {$sum} but found {$decimal_gamma}°.";
        $this->assertAngle(FromDecimal::class, $sum, $gamma, $failure_message);
        $this->assertThat(
            $gamma->toDecimal(),
            $this->logicalAnd(
                $this->greaterThanOrEqual(-360),
                $this->lessThanOrEqual(360)
            ),
            $failure_message
        );
    }

    #[TestDox("corrects the excess if the sum is greater than +/-360°.")]
    public function test_correct_positive_excess()
    {
        // Arrange
        $alfa = Angle::createFromDecimal(360.0);
        $beta = Angle::createFromDecimal(360.0);
        $gamma = Angle::createFromDecimal(-360.0);
        $delta = Angle::createFromDecimal(-360.0);

        // Act
        $sum_1 = new Sum(new FromAngles($alfa, $beta));
        $sum_2 = new Sum(new FromAngles($gamma, $delta));

        // Assert
        $decimal_sum_1 = $sum_1->toDecimal();
        $decimal_sum_2 = $sum_2->toDecimal();
        $this->assertEquals(360.0, $decimal_sum_1);
        $this->assertEquals(-360.0, $decimal_sum_2);
    }

    /**
     * Returns the FromAngles builder class.
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromAngles::class;
    }
}