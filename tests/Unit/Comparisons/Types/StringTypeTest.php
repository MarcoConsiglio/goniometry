<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Types\StringType;
use MarcoConsiglio\Goniometry\Comparisons\Types\InputType;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;


#[TestDox("The StringType ")]
#[CoversClass(StringType::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(Equal::class)]
#[UsesClass(Different::class)]
#[UsesClass(Greater::class)]
#[UsesClass(GreaterOrEqual::class)]
#[UsesClass(Lesser::class)]
#[UsesClass(LesserOrEqual::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(EqualString::class)]
#[UsesClass(DifferentString::class)]
#[UsesClass(GreaterString::class)]
#[UsesClass(GreaterOrEqualString::class)]
#[UsesClass(LesserString::class)]
#[UsesClass(LesserOrEqualString::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Direction::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
class StringTypeTest extends InputTypeTestCase
{
    protected Angle&MockObject $alfa;

    protected string $beta;

    protected InputType $input_type;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa = $this->getMockedAngle();
        $this->beta = (string) $this->randomAngle();
        $this->input_type = new StringType($this->beta);
    }

    #[TestDox("return the strategy for an Equal comparison.")]
    public function test_equal_strategy(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getMockedComparison(Equal::class), 
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(EqualString::class, $strategy);
    }

    #[TestDox("return the strategy for a Different comparison.")]
    public function test_different_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getMockedComparison(Different::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(DifferentString::class, $strategy);
    }

    #[TestDox("return the strategy for a Greater comparison.")]
    public function test_greater_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getMockedComparison(Greater::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(GreaterString::class, $strategy);
    }

    #[TestDox("return the strategy for a GreaterOrEqual comparison.")]
    public function test_greater_or_equal_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getMockedComparison(GreaterOrEqual::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(GreaterOrEqualString::class, $strategy);
    }

    #[TestDox("return the strategy for a Lesser comparison.")]
    public function test_lesser_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getMockedComparison(Lesser::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(LesserString::class, $strategy);
    }

    #[TestDox("return the strategy for a LesserOrEqual comparison.")]
    public function test_lesser_or_equal_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getMockedComparison(LesserOrEqual::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(LesserOrEqualString::class, $strategy);
    }

    /**
     * Return the mocked alfa Angle.
     */
    protected function getMockedAlfa(): Angle&MockObject
    {
        return $this->alfa;
    }

    /**
     * Return the mocked beta Angle.
     */
    protected function getMockedBeta(): string
    {
        return $this->beta;
    }


}