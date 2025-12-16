<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Operations\Sum;
use MarcoConsiglio\Goniometry\Builders\FromAnglesToRelativeSum;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Operations\RelativeSum;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;

#[TestDox("The FromAnglesToRelativeSum builder")]
#[CoversClass(FromAnglesToRelativeSum::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(RelativeSum::class)]
class FromAnglesToRelativeSumTest extends BuilderTestCase
{
    #[TestDox("can sums two angles.")]
    public function test_can_sum_two_angle()
    {
        // Arrange
        $mocked_methods = [
            "bothAnglesAreFullPositiveAngles",
            "bothAnglesAreFullNegativeAngles",
            "bothAnglesAreNullAngles",
            "calcSign",
            "checkOverflow",
            "calcDegrees",
            "calcMinutes",
            "calcSeconds",
            "getMaxSuggestedDecimalPrecisionBetween"
        ];
        $alfa = $this->getMockedAngle();
        $beta = $this->getMockedAngle();
        /** @var FromAnglesToRelativeSum&MockObject $builder */
        $builder = $this->getMockedAngleBuilder($mocked_methods, true, [$alfa, $beta]);
        
        // Assert
        $builder->expects($this->once())->method("calcSign");
        $builder->expects($this->once())->method("checkOverflow");
        $builder->expects($this->once())->method("calcDegrees");
        $builder->expects($this->once())->method("calcMinutes");
        $builder->expects($this->once())->method("calcSeconds");
        $builder->expects($this->any())->method("getMaxSuggestedDecimalPrecisionBetween");
        
        // Act
        $builder->fetchData();
    }

    #[TestDox("can take a shortcut if the two angles are full angles.")]
    public function test_can_shortcut_sum_of_two_full_angles()
    {
        /**
         * 360° + 360° ≅ 360°
         */
        // Arrange
        $alfa = Angle::createFromValues(360);
        $beta = Angle::createFromValues(360);
        $builder = new FromAnglesToRelativeSum($alfa, $beta);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals($result[0], 360);
        $this->assertEquals($result[1], 0);
        $this->assertEquals($result[2], 0.0);
        $this->assertEquals($result[3], Angle::COUNTER_CLOCKWISE);

        /**
         * -360° + (-360°) ≅ -360°
         */
        $alfa = Angle::createFromValues(360, direction: Angle::CLOCKWISE);
        $beta = Angle::createFromValues(360, direction: Angle::CLOCKWISE);
        $builder = new FromAnglesToRelativeSum($alfa, $beta);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals($result[0], 360);
        $this->assertEquals($result[1], 0);
        $this->assertEquals($result[2], 0.0);
        $this->assertEquals($result[3], Angle::CLOCKWISE);
    }

    #[TestDox("can take a shortcut if the two angles are null angles.")]
    public function test_can_shortcut_sum_of_two_null_angles()
    {
        /**
         * 0° + 0° ≅ 0°
         */
        // Arrange
        $alfa = Angle::createFromValues(0);
        $beta = Angle::createFromValues(0);
        $builder = new FromAnglesToRelativeSum($alfa, $beta);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals($result[0], 0);
        $this->assertEquals($result[1], 0);
        $this->assertEquals($result[2], 0.0);
        $this->assertEquals($result[3], Angle::COUNTER_CLOCKWISE);

        /**
         * 0° + 90° ≆ 0
         */
        // Arrange
        $alfa = Angle::createFromValues(0);
        $beta = Angle::createFromValues(90);
        $builder = new FromAnglesToRelativeSum($alfa, $beta);
        
        // Act
        $result = $builder->fetchData();
        $this->assertNotEquals(0, $result[0]);

        /**
         * 90° + 0° ≆ 0°
         */
        $alfa = Angle::createFromValues(0);
        $beta = Angle::createFromValues(90);
        $builder = new FromAnglesToRelativeSum($beta, $alfa);
        
        // Act
        $result = $builder->fetchData();
        $this->assertNotEquals(0, $result[0]);        
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
        $sum_1 = Angle::sum($alfa, $beta);
        $sum_2 = Angle::sum($gamma, $delta);

        // Assert
        $decimal_sum_1 = $sum_1->toDecimal();
        $decimal_sum_2 = $sum_2->toDecimal();
        $this->assertEquals(360.0, $decimal_sum_1);
        $this->assertEquals(-360.0, $decimal_sum_2);
    }

    /**
     * Returns the FromAnglesToRelativeSum builder class.
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromAnglesToRelativeSum::class;
    }
}