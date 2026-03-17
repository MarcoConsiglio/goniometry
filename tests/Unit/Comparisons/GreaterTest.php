<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\FloatComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\Types\IntType;
use MarcoConsiglio\Goniometry\Comparisons\Types\StringType;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Greater comparison")]
#[CoversClass(Greater::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(FromString::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(FloatComparisonStrategy::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(GreaterInt::class)]
#[UsesClass(GreaterFloat::class)]
#[UsesClass(GreaterString::class)]
#[UsesClass(AngleType::class)]
#[UsesClass(IntType::class)]
#[UsesClass(FloatType::class)]
#[UsesClass(StringType::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Direction::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class GreaterTest extends TestCase
{
    protected Angle $alfa;

    protected Angle $beta;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa = $this->randomAngle();
        $this->beta = $this->randomAngle();
    }

    #[TestDox("can compare against an Angle.")]
    public function test_compare_angle(): void
    {
        // Act & Assert
        $comparison = new Greater($this->alfa, $this->beta);
        $this->assertIsBool($comparison->compare());
    }

    #[TestDox("can compare against an int.")]
    public function test_compare_int(): void
    {
        // Act & Assert
        $comparison = new Greater($this->alfa, $this->randomDegrees());
        $this->assertIsBool($comparison->compare());
    }

    #[TestDox("can compare against a float.")]
    public function test_compare_float(): void
    {
        // Act & Assert
        $comparison = new Greater(
            $this->alfa, 
            $this->positiveRandomFloat()
        );
        $comparison->setPrecision($this->randomPrecision());
        $this->assertIsBool($comparison->compare());
    }

    #[TestDox("can compare against a string.")]
    public function test_compare_string(): void
    {
        // Act & Assert
        $comparison = new Greater($this->alfa, (string) $this->beta);
        $this->assertIsBool($comparison->compare());       
    }
}