<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature\Traits;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexagesimal as NegativeSexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexagesimal as PositiveSexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexagesimal as RelativeSexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Sexagesimal as SexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveRadian as PositiveRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Radian as RadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The WithAngleFaker trait")]
#[CoversTrait(WithAngleFaker::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(NegativeSexagesimalGenerator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveRadianGenerator::class)]
#[UsesClass(PositiveRadianValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(PositiveSexagesimalGenerator::class)]
#[UsesClass(Radian::class)]
#[UsesClass(RadianGenerator::class)]
#[UsesClass(RadianRange::class)]
#[UsesClass(RadianValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(RelativeSexagesimalGenerator::class)]
#[UsesClass(Round::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(SexagesimalGenerator::class)]
class WithAngleFakerTest extends TestCase
{
    use WithAngleFaker;

    #[TestDox("can return a random precision.")]
    public function test_randomPrecision(): void
    {
        // Act
        $precision = $this->randomPrecision();

        // Assert
        $this->assertIsInt($precision);
        $this->assertTrue($precision >= 0);
        $this->assertTrue($precision <= PHP_FLOAT_DIG);
    }

    #[TestDox("can return a random degrees value of type int.")]
    public function test_randomDegrees(): void
    {
        // Act
        $degrees = $this->randomDegrees();

        // Assert
        $this->assertIsInt($degrees);
        $this->assertGreaterThanOrEqual(0, $degrees);
        $this->assertLessThan(Degrees::MAX, $degrees);
    }

    #[TestDox("can return a random minutes value of type int.")]
    public function test_randomMinutes(): void
    {
        // Act
        $minutes = $this->randomMinutes();

        // Assert
        $this->assertIsInt($minutes);
        $this->assertGreaterThanOrEqual(0, $minutes);
        $this->assertLessThan(Minutes::MAX, $minutes);
    }

    #[TestDox("can return a random seconds value of type float.")]
    public function test_randomSeconds(): void
    {
        // Act
        $seconds = $this->randomSeconds();

        // Assert
        $this->assertIsFloat($seconds);
        $this->assertGreaterThanOrEqual(0, $seconds);
        $this->assertLessThan(Seconds::MAX, $seconds);
    }

    #[TestDox("can return a random relative Angle instance.")]
    public function test_randomAngle(): void
    {
        // Act & Assert
        $this->assertInstanceOf(Angle::class, $this->randomAngle());
    }

    #[TestDox("can return a random positive Angle instance.")]
    public function test_positiveRandomAngle(): void
    {
        // Act
        $angle = $this->positiveRandomAngle();

        // Assert
        $this->assertInstanceOf(Angle::class, $angle);
        $this->assertSame(Direction::COUNTER_CLOCKWISE, $angle->direction);
    }

    #[TestDox("can return a random negative Angle instance.")]
    public function test_negativeRandomAngle(): void
    {
        // Act
        $angle = $this->negativeRandomAngle();

        // Assert
        $this->assertInstanceOf(Angle::class, $angle);
        $this->assertEquals(Direction::CLOCKWISE, $angle->direction);
    }

    #[TestDox("can return a random direction.")]
    public function test_randomDirection(): void
    {
        // Act & Assert
        $this->assertInstanceOf(Direction::class, $this->randomDirection());
    }

    #[TestDox("can return a random relative sexagesimal string.")]
    public function test_randomSexagesimalString(): void
    {
        /**
         * Positive sexagesimal
         */
        // Act
        $sexagesimal_string = $this->randomSexagesimalString(
            0.0, SexadecimalRange::max()
        );

        // Assert
        $this->assertStringNotContainsString('-', $sexagesimal_string);

        /**
         * Negative sexagesimal
         */
        // Act
        $sexagesimal_string = $this->randomSexagesimalString(
            SexadecimalRange::min(), NextFloat::beforeZero()
        );
        
        // Assert
        $this->assertStringContainsString('-', $sexagesimal_string);
    }

    #[TestDox("can return random sexagesimal values composed of degrees, minutes, seconds and direction.")]
    public function test_randomSexagesimal(): void
    {
        // Act
        $sexagesimal_values = $this->randomSexagesimal();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal_values);
    }

    #[TestDox("can return random positive sexagesimal values composed of degrees, minutes, seconds and direction.")]
    public function test_positiveRandomSexagesimal(): void
    {
        // Act
        $sexagesimal_values = $this->positiveRandomSexagesimal();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal_values);
        $this->assertEquals(Direction::COUNTER_CLOCKWISE, $sexagesimal_values->direction);
    }

    #[TestDox("can return random negative sexagesimal values composed of degrees, minutes, seconds and direction.")]
    public function test_negativeRandomSexagesimal(): void
    {
        // Act
        $sexagesimal_values = $this->negativeRandomSexagesimal();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal_values);
        $this->assertEquals(Direction::CLOCKWISE, $sexagesimal_values->direction);
    }

    #[TestDox("can return a random sexadecimal value.")]
    public function test_randomSexadecimal(): void
    {
        // Act 
        $sexadecimal = $this->randomSexadecimal();

        // Assert
        $this->assertIsFloat($sexadecimal);
        $this->assertGreaterThan(-Degrees::MAX, $sexadecimal);
        $this->assertLessThan(Degrees::MAX, $sexadecimal);
    }

    #[TestDox("can return a random positive sexadecimal value.")]
    public function test_positiveRandomSexadecimal(): void
    {
        // Act
        $sexadecimal = $this->positiveRandomSexadecimal();

        // Assert
        $this->assertIsFloat($sexadecimal);
        $this->assertGreaterThanOrEqual(0, $sexadecimal);
        $this->assertLessThan(Degrees::MAX, $sexadecimal);
    }

    #[TestDox("can return a random negative sexadecimal value.")]
    public function test_negativeRandomSexadecimal(): void
    {
        // Act
        $sexadecimal = $this->negativeRandomSexadecimal();

        // Assert
        $this->assertIsFloat($sexadecimal);
        $this->assertTrue($sexadecimal < 0);
    }

    #[TestDox("can return a random radian value.")]
    public function test_randomRadian(): void
    {
        // Act & Assert
        $this->assertIsFloat($this->randomRadian());
    }

    #[TestDox("can return a random positive radian value.")]
    public function test_positiveRandomRadian(): void
    {
        // Act
        $radian = $this->positiveRandomRadian();

        // Assert
        $this->assertInstanceOf(Radian::class, $radian);
    }
        
    #[TestDox("can return a random negative radian value.")]
    public function test_negativeRandomRadian(): void
    {
        // Act
        $radian = $this->negativeRandomRadian();
        
        // Assert
        $this->assertIsFloat($radian);
        $this->assertTrue($radian < 0);
    }
}