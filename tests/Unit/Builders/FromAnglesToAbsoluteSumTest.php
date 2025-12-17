<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromAnglesToAbsoluteSum;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;

#[TestDox("The FromAnglesToAbsoluteSum builder")]
#[CoversClass(FromAnglesToAbsoluteSum::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDegrees::class)]
class FromAnglesToAbsoluteSumTest extends BuilderTestCase
{
    public function test_can_sum_two_angles()
    {
        // Arrange
        $mocked_methods = [
            "bothAnglesAreFullPositiveAngles",
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
        /** @var FromAnglesToAbsoluteSum&MockObject $builder */
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
        $builder = new FromAnglesToAbsoluteSum($alfa, $beta);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals($result[0], 360);
        $this->assertEquals($result[1], 0);
        $this->assertEquals($result[2], 0.0);
        $this->assertEquals($result[3], Angle::COUNTER_CLOCKWISE);
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
        $builder = new FromAnglesToAbsoluteSum($alfa, $beta);

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
        $builder = new FromAnglesToAbsoluteSum($alfa, $beta);
        
        // Act
        $result = $builder->fetchData();
        $this->assertNotEquals(0, $result[0]);

        /**
         * 90° + 0° ≆ 0°
         */
        $alfa = Angle::createFromValues(0);
        $beta = Angle::createFromValues(90);
        $builder = new FromAnglesToAbsoluteSum($beta, $alfa);
        
        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertNotEquals(0, $result[0]);        
    }

    #[TestDox("consider negative angles as positive angles.")]
    public function test_negative_angles_is_considered_positive_angles()
    {
        /**
         * 1° - 181° = 181°
         */
        // Arrange
        $alfa = Angle::createFromValues(1);
        $beta = Angle::createFromValues(180, direction: Angle::CLOCKWISE);
        $builder = new FromAnglesToAbsoluteSum($alfa, $beta);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals(181, $result[0]);

        /**
         * -30° + (-60°) = 270°
         */
        // Arrange
        $alfa = Angle::createFromValues(30, direction: Angle::CLOCKWISE);
        $beta = Angle::createFromValues(60, direction: Angle::CLOCKWISE);
        $builder = new FromAnglesToAbsoluteSum($alfa, $beta);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals(270, $result[0]);

        /**
         * 30 + (-90°) = 300°
         */
        // Arrange
        $alfa = Angle::createFromValues(30);
        $beta = Angle::createFromValues(90);
        $builder = new FromAnglesToAbsoluteSum($alfa, $beta);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals(120, $result[0]);       
    }

    /**
     * Returns the FromAnglesToAbsoluteSum to test.
     * 
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromAnglesToAbsoluteSum::class;
    }
}