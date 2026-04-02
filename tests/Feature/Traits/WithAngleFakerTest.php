<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature\Traits;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
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
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(Round::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
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
        $this->assertTrue($angle->toFloat() >= 0);
        $this->assertTrue($angle->toFloat() < Degrees::MAX);
        $this->assertEquals(Direction::COUNTER_CLOCKWISE, $angle->direction);
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

    #[TestDox("can return a random sexagesimal string.")]
    public function test_randomSexagesimalString(): void
    {
        // Act & Assert
        $this->assertIsString($this->randomSexagesimalString());
    }

    #[TestDox("can return random sexagesimal values composed of degrees, minutes, seconds and direction.")]
    public function test_randomSexagesimal(): void
    {
        // Act
        [$degrees, $minutes, $seconds, $direction] = $this->randomSexagesimal();

        // Assert
        $this->assertIsInt($degrees);
        $this->assertIsInt($minutes);
        $this->assertIsFloat($seconds);
        $this->assertInstanceOf(Direction::class, $direction);
    }

    #[TestDox("can return random positive sexagesimal values composed of degrees, minutes, seconds and direction.")]
    public function test_positiveRandomSexagesimal(): void
    {
        // Act
        [$degrees, $minutes, $seconds, $direction] = $this->positiveRandomSexagesimal();

        // Assert
        $this->assertEquals(Direction::COUNTER_CLOCKWISE, $direction);
    }

    #[TestDox("can return random negative sexagesimal values composed of degrees, minutes, seconds and direction.")]
    public function test_negativeRandomSexagesimal(): void
    {
        // Act
        [$degrees, $minutes, $seconds, $direction] = $this->negativeRandomSexagesimal();

        // Assert
        $this->assertEquals(Direction::CLOCKWISE, $direction);
    }

    #[TestDox("can return a random sexadecimal value.")]
    public function test_randomSexadecimal(): void
    {
        // Act & Assert
        $this->assertIsFloat($this->randomSexadecimal());
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
        $this->assertIsFloat($radian);
        $this->assertTrue($radian >= 0);
        $this->assertTrue($radian < Radian::MAX);
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