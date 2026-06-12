<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\AngularDistanceRadian;
use MarcoConsiglio\Goniometry\Builders\Angle\AbsoluteSum;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal as AngleFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal as AngleFromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromString as AngleFromString;
use MarcoConsiglio\Goniometry\Builders\Angle\SumBuilder;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromAngles;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromRadian;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromString;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\RelativeSum;
use MarcoConsiglio\Goniometry\Casting\Radian\Cast as CastToRadian;
use MarcoConsiglio\Goniometry\Casting\Radian\Round as RoundRadian;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round as RoundSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Comparison as GeneralComparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Comparison as FuzzyComparison;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Equal as FuzzyEqual;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Types\AngularDistanceType as FuzzyAngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\Fuzzy\EqualAngularDistance as FuzzyEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\AngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\IntType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\StringType;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\FloatGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngularDistance as NegativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngularDistance as PositiveAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeRadian as RelativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeAngularDistance as NegativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveAngularDistance as PositiveAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(AngularDistance::class)]
#[UsesClass(AbsoluteSum::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleFromSexadecimal::class)]
#[UsesClass(AngleFromSexagesimal::class)]
#[UsesClass(AngleFromString::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(AngularDistanceRadian::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(AngularDistanceType::class)]
#[UsesClass(CastToRadian::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(Different::class)]
#[UsesClass(DifferentAngularDistance::class)]
#[UsesClass(DifferentFloat::class)]
#[UsesClass(DifferentInt::class)]
#[UsesClass(DifferentString::class)]
#[UsesClass(Equal::class)]
#[UsesClass(EqualAngularDistance::class)]
#[UsesClass(EqualFloat::class)]
#[UsesClass(EqualInt::class)]
#[UsesClass(EqualString::class)]
#[UsesClass(FloatGenerator::class)]
#[UsesClass(FloatType::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromAngles::class)]
#[UsesClass(FromRadian::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(FromString::class)]
#[UsesClass(FuzzyAngularDistanceType::class)]
#[UsesClass(FuzzyComparison::class)]
#[UsesClass(FuzzyEqual::class)]
#[UsesClass(FuzzyEqualAngularDistance::class)]
#[UsesClass(GeneralComparison::class)]
#[UsesClass(Greater::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(GreaterAngularDistance::class)]
#[UsesClass(GreaterFloat::class)]
#[UsesClass(GreaterInt::class)]
#[UsesClass(GreaterOrEqual::class)]
#[UsesClass(GreaterOrEqualAngle::class)]
#[UsesClass(GreaterOrEqualAngularDistance::class)]
#[UsesClass(GreaterOrEqualFloat::class)]
#[UsesClass(GreaterOrEqualInt::class)]
#[UsesClass(GreaterOrEqualString::class)]
#[UsesClass(GreaterString::class)]
#[UsesClass(IntType::class)]
#[UsesClass(Lesser::class)]
#[UsesClass(LesserAngle::class)]
#[UsesClass(LesserAngularDistance::class)]
#[UsesClass(LesserFloat::class)]
#[UsesClass(LesserInt::class)]
#[UsesClass(LesserOrEqual::class)]
#[UsesClass(LesserOrEqualAngle::class)]
#[UsesClass(LesserOrEqualAngularDistance::class)]
#[UsesClass(LesserOrEqualFloat::class)]
#[UsesClass(LesserOrEqualInt::class)]
#[UsesClass(LesserOrEqualString::class)]
#[UsesClass(LesserString::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeAngularDistanceGenerator::class)]
#[UsesClass(NegativeAngularDistanceValidator::class)]
#[UsesClass(NegativeRadianGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveAngularDistanceGenerator::class)]
#[UsesClass(PositiveAngularDistanceValidator::class)]
#[UsesClass(PositiveRadianGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(Radian::class)]
#[UsesClass(RadianGenerator::class)]
#[UsesClass(RadianRange::class)]
#[UsesClass(RelativeAngleGenerator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesClass(RelativeRadianGenerator::class)]
#[UsesClass(RelativeRadianValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(RelativeSum::class)]
#[UsesClass(RoundRadian::class)]
#[UsesClass(RoundSexadecimal::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsRange::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(StringType::class)]
#[UsesClass(SumBuilder::class)]
#[UsesTrait(WithAngleFaker::class)]
class AngularDistanceTest extends TestCase
{
    #[TestDox("can be create from sexagesimal values.")]
    public function test_create_from_values(): void
    {
        // Act
        $angle = AngularDistance::createFromValues(
            $this->randomDegrees()->value(),
            $this->randomMinutes()->value(),
            $this->randomSeconds()->value(),
            $this->randomDirection()
        );

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
    }

    #[TestDox("can be created from a decimal number.")]
    public function test_create_from_decimal(): void
    {
        // Arrange
        $decimal = $this->randomSexadecimal(
            min: AngularDistanceRange::min(),
            max: AngularDistanceRange::max(),
            precision: 3
        );

        // Act
        $angle = AngularDistance::createFromDecimal($decimal);

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
    }

    #[TestDox("can be created from a radian number.")]
    public function test_create_from_radian(): void
    {
        // Arrange
        $radian = $this->randomRadian(Radian::MIN / 2, Radian::MAX / 2);

        // Act
        $angle = AngularDistance::createFromRadian(new AngularDistanceRadian($radian->value));

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
    }

    #[TestDox("can be created from a sexagesimal string.")]
    public function test_create_from_string(): void
    {
        // Arrange
        $string = (string) $this->randomAngle(precision: 3);

        // Act
        $angle = AngularDistance::createFromString($string);

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
    }

    #[TestDox("can be calculated between two Angle instances.")]
    public function test_create_from_angles(): void
    {
        // Arrange
        $alfa = $this->randomAngle();
        $beta = $this->randomAngle();

        // Act
        $distance = AngularDistance::between($alfa, $beta);

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $distance);
    }

    #[TestDox("can output degrees, minutes and seconds wrapped in a simple or associative array.")]
    public function test_get_angle_values_in_array(): void
    {
        // Arrange
        $alfa = AngularDistance::createFromValues(
            $degrees = $this->randomDegrees(max: 179)->value(), 
            $minutes = $this->randomMinutes()->value(), 
            $seconds = $this->randomSeconds()->value(1),
            $direction = $this->randomDirection()
        );
        $degrees *= $direction->value;

        // Act
        $simple_result = $alfa->getDegrees(precision: 1);
        $associative_result = $alfa->getDegrees(associative: true, precision: 1);

        // Assert
        $fail_message = "Input: {$alfa}\nOutput:{$degrees}°{$minutes}'{$seconds}\"";
        $this->assertEquals($degrees, $simple_result[0], $fail_message);
        $this->assertEquals($minutes, $simple_result[1], $fail_message);
        $this->assertEquals($seconds, $simple_result[2], $fail_message);
        $this->assertEquals($degrees, $associative_result["degrees"], $fail_message);
        $this->assertEquals($minutes, $associative_result["minutes"], $fail_message);
        $this->assertEquals($seconds, $associative_result["seconds"], $fail_message);
    }

    #[TestDox("can return its absolute value.")]
    public function test_absolute(): void
    {
        // Arrange
        $angle = $this->negativeRandomAngularDistance();

        // Act & Assert
        $this->assertTrue($angle->asb()->isCounterClockwise());
    }

    #[TestDox("can toggle its direction.")]
    public function test_can_toggle_rotation_direction(): void
    {
        /**
         * With SexadecimalDegrees
         */
        // Arrange
        $failure_message_1 = "The angle should be counterclockwise but found the opposite.";
        $failure_message_2 = "The angle should be clockwise but found the opposite.";
        $alfa = $this->positiveRandomAngularDistance();
        $beta = $this->negativeRandomAngularDistance();

        // Act & Assert
        $this->assertDirection(
            $alfa->direction->opposite(), 
            $alfa->oppositeRotation()->direction, 
            $failure_message_2
        );
        $this->assertDirection(
            $beta->direction->opposite(), 
            $beta->oppositeRotation()->direction, 
            $failure_message_1
        );
    }

    #[TestDox("can be clockwise or negative.")]
    public function test_angle_is_clockwise(): void
    {
        // Arrange
        $alfa = $this->negativeRandomAngularDistance();

        // Act & assert
        $this->assertTrue($alfa->isClockwise(), "The angle is clockwise but found the opposite.");
        $this->assertFalse($alfa->isCounterClockwise(), "The angle is not counter clockwise but found the opposite.");
    }

    #[TestDox("can be counterclockwise or positive.")]
    public function test_angle_is_counterclockwise(): void
    {
        // Arrange
        $alfa = $this->positiveRandomAngularDistance();

        // Act & assert
        $this->assertTrue($alfa->isCounterClockwise(), "The angle is clockwise but found the opposite.");
        $this->assertFalse($alfa->isClockwise(), "The angle is not clockwise but found the opposite.");
    }

    #[TestDox("can be casted to SexagesimalDegrees.")]
    public function test_cast_angle_to_sexagesimal(): void
    {
        // Arrange
        $angle = $this->randomAngularDistance(precision: 3);

        // Act 
        $sexagesimal = $angle->toSexagesimalDegrees();

        // Assert
        $this->assertDegrees($angle->degrees, $sexagesimal->degrees);
        $this->assertMinutes($angle->minutes, $sexagesimal->minutes);
        $this->assertSeconds($angle->seconds, $sexagesimal->seconds);
        $this->assertDirection($angle->direction, $sexagesimal->direction);
    }

    #[TestDox("can be casted to radian.")]
    public function test_cast_to_radian(): void
    {
        /**
         * Without radian
         */
        // Arrange
        $angle = $this->randomAngularDistance();

        // Act & Assert
        $this->assertIsFloat($angle->toRadian());

        /**
         * With radian
         */
        // Arrange
        $angle = AngularDistance::createFromRadian(
            $this->randomRadian(
                min: NextFloat::after(AngularDistanceRadian::MIN),
                max: NextFloat::before(AngularDistanceRadian::MAX)
            )->value()
        );

        // Act & Assert
        $this->assertIsFloat($angle->toRadian());
    }

    #[TestDox("can be equal compared against an int, float, string or Angle.")]
    public function test_equal_comparison(): void
    {
        // Arrange
        $alfa = $this->randomAngularDistance();
        $int_beta = $this->randomDegrees(max: AngularDistance::MAX - 1)->value();
        $string_beta = (string) $this->randomAngularDistance();
        $float_beta = $this->randomAngularDistance()->toFloat();
        $angle_beta = $this->randomAngularDistance();

        // Act & Assert
        $this->assertIsBool($alfa->eq($int_beta));
        $this->assertIsBool($alfa->eq($string_beta));
        $this->assertIsBool($alfa->eq($float_beta));
        $this->assertIsBool($alfa->eq($angle_beta));
    }

    #[TestDox("can be different compared against an int, float, string or Angle.")]
    public function test_different_comparison(): void
    {
        // Arrange
        $alfa = $this->randomAngularDistance();
        $int_beta = $this->randomDegrees(max: AngularDistance::MAX - 1)->value();
        $string_beta = (string) $this->randomAngularDistance();
        $float_beta = $this->randomAngularDistance()->toFloat();
        $angle_beta = $this->randomAngularDistance();

        // Act & Assert
        $this->assertIsBool($alfa->not($int_beta));
        $this->assertIsBool($alfa->not($string_beta));
        $this->assertIsBool($alfa->not($float_beta));
        $this->assertIsBool($alfa->not($angle_beta));
    }

    #[TestDox("can be greater compared against an int, float, string or Angle.")]
    public function test_greater_comparison(): void
    {
        // Arrange
        $alfa = $this->randomAngularDistance();
        $int_beta = $this->randomDegrees(max: AngularDistance::MAX - 1)->value();
        $string_beta = (string) $this->randomAngularDistance();
        $float_beta = $this->randomAngularDistance()->toFloat();
        $angle_beta = $this->randomAngularDistance();

        // Act & Assert
        $this->assertIsBool($alfa->gt($int_beta));
        $this->assertIsBool($alfa->gt($string_beta));
        $this->assertIsBool($alfa->gt($float_beta));
        $this->assertIsBool($alfa->gt($angle_beta));
    }

    #[TestDox("can be greater or equal compared against an int, float, string or Angle.")]
    public function test_greater_or_equal_comparison(): void
    {
        // Arrange
        $alfa = $this->randomAngularDistance();
        $int_beta = $this->randomDegrees(max: AngularDistance::MAX - 1)->value();
        $string_beta = (string) $this->randomAngularDistance();
        $float_beta = $this->randomAngularDistance()->toFloat();
        $angle_beta = $this->randomAngularDistance();

        // Act & Assert
        $this->assertIsBool($alfa->gte($int_beta));
        $this->assertIsBool($alfa->gte($string_beta));
        $this->assertIsBool($alfa->gte($float_beta));
        $this->assertIsBool($alfa->gte($angle_beta));
    }

    #[TestDox("can be lesser compared against an int, float, string or Angle.")]
    public function test_lesser_comparison(): void
    {
        // Arrange
        $alfa = $this->randomAngularDistance();
        $int_beta = $this->randomDegrees(max: AngularDistance::MAX - 1)->value();
        $string_beta = (string) $this->randomAngularDistance();
        $float_beta = $this->randomAngularDistance()->toFloat();
        $angle_beta = $this->randomAngularDistance();

        // Act & Assert
        $this->assertIsBool($alfa->lt($int_beta));
        $this->assertIsBool($alfa->lt($string_beta));
        $this->assertIsBool($alfa->lt($float_beta));
        $this->assertIsBool($alfa->lt($angle_beta));       
    }

    #[TestDox("can be lesser or equal compared against an int, float, string or Angle.")]
    public function test_lesser_or_equal_comparison(): void
    {
        // Arrange
        $alfa = $this->randomAngularDistance();
        $int_beta = $this->randomDegrees(max: AngularDistance::MAX - 1)->value();
        $string_beta = (string) $this->randomAngularDistance();
        $float_beta = $this->randomAngularDistance()->toFloat();
        $angle_beta = $this->randomAngularDistance();

        // Act & Assert
        $this->assertIsBool($alfa->lte($int_beta));
        $this->assertIsBool($alfa->lte($string_beta));
        $this->assertIsBool($alfa->lte($float_beta));
        $this->assertIsBool($alfa->lte($angle_beta));      
    }

    #[TestDox("can be almost equal compared to another angle considering an acceptable error.")]
    public function test_fuzzy_equal_comparison(): void
    {
        // Arrange
        $alfa = $this->positiveRandomAngularDistance();
        $beta = $this->positiveRandomAngularDistance();
        $delta = $this->positiveRandomAngle();

        // Act & Assert
        $this->assertIsBool($alfa->feq($beta, $delta));
    }

    #[TestDox("can be added to another Angle.")]
    public function test_sum(): void
    {
        // Arrange
        $alfa = $this->randomAngularDistance();
        $beta = $this->randomAngle();

        // Act
        $result = $alfa->sum($beta);

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $result);
    }

    #[TestDox("can return the opposite direction AngularDistance.")]
    public function test_opposite_direction(): void
    {
        // Arrange
        $angle = $this->randomAngularDistance();
        if ($angle->isClockwise())
            $opposite_sexadecimal = new SexadecimalAngularDistance(
                $angle->toSexadecimalDegrees()->value->plus(-180)
            );
        else
            $opposite_sexadecimal = new SexadecimalAngularDistance(
                $angle->toSexadecimalDegrees()->value->plus(Degrees::MAX)->plus(-180)
            );

        // Act
        $opposite_angle = $angle->oppositeDirection();

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $opposite_angle);
        $this->assertEquals(
            $opposite_sexadecimal->value, 
            $opposite_angle->toSexadecimalDegrees()->value,
            "The opposite of {$angle} is {$opposite_angle}."
        );
    }

    #[TestDox("can be cloned.")]
    public function test_clone(): void
    {
        /**
         * Built from sexagesimal values
         */
        // Arrange
        $angle = AngularDistance::createFromValues(
            $this->randomDegrees()->value(),
            $this->randomMinutes()->value(),
            $this->randomSeconds()->value(),
            $this->randomDirection()
        );

        // Act
        $clone = clone $angle;

        // Assert
        $this->assertDegrees($angle->degrees, $clone->degrees);
        $this->assertMinutes($angle->minutes, $clone->minutes);
        $this->assertSeconds($angle->seconds, $clone->seconds);
        $this->assertDirection($angle->direction, $clone->direction);

        /**
         * Built from sexadecimal value
         */
        // Arrange
        $angle = AngularDistance::createFromValues(
            $this->randomSexadecimal()
        );

        // Act
        $clone = clone $angle;

        // Assert
        $this->assertDegrees($angle->degrees, $clone->degrees);
        $this->assertMinutes($angle->minutes, $clone->minutes);
        $this->assertSeconds($angle->seconds, $clone->seconds);
        $this->assertDirection($angle->direction, $clone->direction);
        
        /**
         * Built from radian value
        */
        // Arrange
        $angle = AngularDistance::createFromRadian(
            $this->randomRadian()->value()
        );

        // Act
        $clone = clone $angle;

        // Assert
        $this->assertDegrees($angle->degrees, $clone->degrees);
        $this->assertMinutes($angle->minutes, $clone->minutes);
        $this->assertSeconds($angle->seconds, $clone->seconds);
        $this->assertDirection($angle->direction, $clone->direction);
    }
}