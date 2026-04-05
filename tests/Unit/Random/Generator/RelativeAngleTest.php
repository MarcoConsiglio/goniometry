<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(RelativeAngleGenerator::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
class RelativeAngleTest extends GeneratorTestCase
{
    public function test_random_generation(): void
    {
        /**
         * Positive range
         */
        // Arrange
        $validator = $this->createMock(RelativeSexadecimalValidator::class);
        $validator->expects($this->once())->method("validate");
        $generator = new RelativeAngleGenerator(
            self::$faker,
            $validator,
            new SexadecimalRange(0.0, SexadecimalRange::max())
        );

        // Act & Assert
        $this->assertInstanceOf(Angle::class, $generator->generate());

        /**
         * Negative range
         */
        // Arrange
        $validator = $this->createMock(RelativeSexadecimalValidator::class);
        $validator->expects($this->once())->method("validate");
        $generator = new RelativeAngleGenerator(
            self::$faker,
            $validator,
            new SexadecimalRange(SexadecimalRange::min(), NextFloat::beforeZero())
        );

        // Act & Assert
        $this->assertInstanceOf(Angle::class, $generator->generate());

        /**
         * Relative range
         * Positive outcome
         */
        // Arrange
        $validator = $this->createMock(RelativeSexadecimalValidator::class);
        $validator->expects($this->once())->method("validate");  
        $generator = new RelativeAngleGenerator(
            $this->trickFakerToGetTrueOut(),
            $validator,
            new SexadecimalRange(SexadecimalRange::min(), SexadecimalRange::max())
        );
        
        // Act
        $angle = $generator->generate();

        // Assert
        $this->assertInstanceOf(Angle::class, $angle);
        $this->assertSame(Direction::COUNTER_CLOCKWISE, $angle->direction);

        /**
         * Relative range
         * Negative outcome
         */
        // Arrange
        $validator = $this->createMock(RelativeSexadecimalValidator::class);
        $validator->expects($this->once())->method("validate");  
        $generator = new RelativeAngleGenerator(
            $this->trickFakerToGetFalseOut(),
            $validator,
            new SexadecimalRange(SexadecimalRange::min(), SexadecimalRange::max())
        );
        
        // Act
        $angle = $generator->generate();

        // Assert
        $this->assertInstanceOf(Angle::class, $angle);
        $this->assertSame(Direction::CLOCKWISE, $angle->direction);
    }
}