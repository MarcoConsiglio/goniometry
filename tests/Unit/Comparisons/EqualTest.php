<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualString;
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
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Equal comparison")]
#[CoversClass(Equal::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(FromString::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(FloatComparisonStrategy::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(EqualInt::class)]
#[UsesClass(EqualFloat::class)]
#[UsesClass(EqualString::class)]
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
class EqualTest extends TestCase
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
        $comparison = new Equal($this->alfa, $this->beta);
        $this->assertIsBool($comparison->compare());
    }

    #[TestDox("can compare against an int.")]
    public function test_compare_int(): void
    {
        // Act & Assert
        $comparison = new Equal($this->alfa, $this->randomDegrees());
        $this->assertIsBool($comparison->compare());
    }

    #[TestDox("can compare against a float.")]
    public function test_compare_float(): void
    {
        // Act & Assert
        $comparison = new Equal(
            $this->alfa, 
            $this->randomSexadecimal()
        );
        $comparison->setPrecision($this->positiveRandomFloat(max: PHP_FLOAT_DIG));
        $this->assertIsBool($comparison->compare());
    }

    public function test_compare_float_with_normalized_precision(): void
    {
        // Act & Assert
        $comparison = new Equal(
            $this->alfa,
            $this->randomSexadecimal()
        );
        $comparison->setPrecision($this->negativeRandomInteger(min: 54));
        $this->assertIsBool($comparison->compare());
    }

    #[TestDox("can compare against a string.")]
    public function test_compare_string(): void
    {
        // Act & Assert
        $comparison = new Equal($this->alfa, (string) $this->beta);
        $this->assertIsBool($comparison->compare());       
    }
}