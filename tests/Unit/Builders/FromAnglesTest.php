<?php
namespace MarcoConsiglio\Trigonometry\Tests\Unit\Builders;

use MarcoConsiglio\Trigonometry\Angle;
use MarcoConsiglio\Trigonometry\Operations\Sum;
use MarcoConsiglio\Trigonometry\Builders\FromAngles;
use MarcoConsiglio\Trigonometry\Builders\FromDecimal;
use MarcoConsiglio\Trigonometry\Builders\FromDegrees;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The FromAngles builder")]
#[CoversClass(FromAngles::class)]
#[CoversClass(Sum::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(FromDecimal::class)]
// #[UsesClass(AngleInterface::class)]
class FromAnglesTest extends BuilderTestCase
{
    #[TestDox("can sums two angles.")]
    /**
     * This test fails sometime.
     */
    public function test_can_sum_two_angle()
    {
        // Arrange
        $alfa = $this->getRandomAngle();
        $beta = $this->getRandomAngle();

        // Act
        $gamma = new Sum(new FromAngles($alfa, $beta));
        
        // Assert
        $decimal_alfa = $alfa->toDecimal();
        $decimal_beta = $beta->toDecimal();
        $decimal_gamma = $gamma->toDecimal();
        $sum = round($alfa->toDecimal() + $beta->toDecimal(), 1, PHP_ROUND_HALF_DOWN);
        while ($sum > Angle::MAX_DEGREES) {
            $sum = round($sum - Angle::MAX_DEGREES, 1);
        }
        $failure_message_1 = "{$decimal_alfa}° + {$decimal_beta}° must equal {$sum}° but found {$decimal_gamma}°.";
        $failure_message_2 = "{$decimal_alfa}° + {$decimal_beta}° must be inside the limit -360°/+360° but found {$decimal_gamma}°.";
        $this->assertEquals($sum, $gamma->toDecimal(), $failure_message_1);
        $this->assertThat(
            $sum,
            $this->logicalAnd(
                $this->greaterThanOrEqual(-360),
                $this->lessThanOrEqual(360)
            ),
            $failure_message_2
        );
    }

    #[TestDox("corrects positive excess if the sum is greater than 360°.")]
    public function test_correct_positive_excess()
    {
        // Arrange
        $alfa = Angle::createFromDecimal(360.0);
        $beta = Angle::createFromDecimal(360.0);

        // Act
        $gamma = new Sum(new FromAngles($alfa, $beta));

        // Assert
        $decimal_gamma = $gamma->toDecimal();
        $this->assertEquals(360.0, $decimal_gamma);
    }

    #[TestDox("corrects negative excess if the sum is less than -360°.")]
    public function test_correct_negative_excess()
    {
        // Arrange
        $alfa = Angle::createFromDecimal(-360.0);
        $beta = Angle::createFromDecimal(-360.0);

        // Act
        $gamma = new Sum(new FromAngles($alfa, $beta));

        // Assert
        $decimal_gamma = $gamma->toDecimal();
        $this->assertEquals(-360.0, $decimal_gamma); 
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