<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromAnglesToRelativeSum;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;

#[TestDox("The FromAnglesToRelativeSum builder")]
#[CoversClass(FromAnglesToRelativeSum::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDegrees::class)]
class FromAnglesToRelativeSumTest extends BuilderTestCase
{
    #[TestDox("can sums two relatives angles.")]
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

    #[TestDox("supports relative sum.")]
    public function test_calc_sign()
    {
        /**
         * Positive sum
         */
        // Arrange
        $alfa = Angle::createFromValues(30);
        $beta = Angle::createFromValues(30);
        $builder = new FromAnglesToRelativeSum($alfa, $beta);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals(Angle::COUNTER_CLOCKWISE, $result[3]);

        /**
         * Negative sum
         */
        $alfa = Angle::createFromValues(30, direction: Angle::CLOCKWISE);
        $beta = Angle::createFromValues(30, direction: Angle::CLOCKWISE);
        $builder = new FromAnglesToRelativeSum($alfa, $beta);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals(Angle::CLOCKWISE, $result[3]);
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
        $this->assertEquals(0, $result[0]);
        $this->assertEquals(0, $result[1]);
        $this->assertEquals(0.0, $result[2]);
        $this->assertEquals(Angle::COUNTER_CLOCKWISE, $result[3]);

        /**
         * 0° + 90° ≆ 0
         */
        // Arrange
        $alfa = Angle::createFromValues(0);
        $beta = Angle::createFromValues(90);
        $builder = new FromAnglesToRelativeSum($alfa, $beta);
        
        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertNotEquals(0, $result[0]);
        $this->assertEquals(Angle::COUNTER_CLOCKWISE, $result[3]);

        /**
         * 90° + 0° ≆ 0°
         */
        $alfa = Angle::createFromValues(0);
        $beta = Angle::createFromValues(90);
        $builder = new FromAnglesToRelativeSum($beta, $alfa);
        
        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertNotEquals(0, $result[0]);
        $this->assertEquals(Angle::COUNTER_CLOCKWISE, $result[3]);        
    }

    #[TestDox("corrects the excess if the sum is greater than +/-360°.")]
    public function test_correct_positive_excess()
    {
        // Arrange
        $alfa = Angle::createFromValues(360);
        $beta = Angle::createFromValues(360);
        $gamma = Angle::createFromValues(360, direction: Angle::CLOCKWISE);
        $delta = Angle::createFromValues(360, direction: Angle::CLOCKWISE);
        $builder_1 = new FromAnglesToRelativeSum($alfa, $beta);
        $builder_2 = new FromAnglesToRelativeSum($gamma, $delta);

        // Act
        $result_1 = $builder_1->fetchData();
        $result_2 = $builder_2->fetchData();

        // Assert
        $this->assertEquals(360, $result_1[0]);
        $this->assertEquals(Angle::COUNTER_CLOCKWISE, $result_1[3]);
        $this->assertEquals(360, $result_2[0]);
        $this->assertEquals(Angle::CLOCKWISE, $result_2[3]);
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