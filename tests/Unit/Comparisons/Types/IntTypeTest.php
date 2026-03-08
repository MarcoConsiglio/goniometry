<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\Types\IntType;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;


#[TestDox("The IntType ")]
#[CoversClass(IntType::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(Equal::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(EqualInt::class)]
#[UsesClass(AngleType::class)]
class IntTypeTest extends TestCase
{
    #[TestDox("return the strategy for an Equal comparison.")]
    public function test_equal_strategy(): void
    {
        // Arrange
        /** @var Angle&MockObject $alfa */
        $alfa = $this->getMockedAngle();
        /** @var Angle&MockObject $beta */
        $beta = $this->getMockedAngle();
        $equal_comparison = 
            $this->getMockBuilder(Equal::class)
                 ->enableOriginalConstructor()
                 ->setConstructorArgs([$alfa, $beta])
                 ->getMock();
        $input_type = new IntType($this->randomDegrees());

        // Act
        $strategy = $input_type->getStrategyFor($equal_comparison, $alfa);

        // Assert
        $this->assertInstanceOf(EqualInt::class, $strategy);
    }
}