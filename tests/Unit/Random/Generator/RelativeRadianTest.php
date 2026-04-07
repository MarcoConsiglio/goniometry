<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeRadian as RelativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeRadian as NegativeRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveRadian as PositiveRadianValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(RelativeRadianGenerator::class)]
#[UsesClass(Radian::class)]
#[UsesClass(NegativeRadianGenerator::class)]
#[UsesClass(PositiveRadianGenerator::class)]
#[UsesClass(RadianRange::class)]
#[UsesClass(NegativeRadianValidator::class)]
#[UsesClass(PositiveRadianValidator::class)]
#[UsesClass(RelativeRadianValidator::class)]
class RelativeRadianTest extends GeneratorTestCase
{
    public function test_random_generation(): void
    {
        /**
         * Positive range
         */
        // Arrange
        $generator = new RelativeRadianGenerator(
            self::$faker,
            new RelativeRadianValidator,
            new RadianRange(0.0, RadianRange::max())
        );

        // Act & Assert
        $this->assertInstanceOf(Radian::class, $generator->generate());

        /**
         * Negative range
         */
        // Arrange
        $generator = new RelativeRadianGenerator(
            self::$faker,
            new RelativeRadianValidator,
            new RadianRange(RadianRange::min(), NextFloat::beforeZero())
        );

        // Act & Assert
        $this->assertInstanceOf(Radian::class, $generator->generate());

        /**
         * Relative range
         * Positive outcome
         */
        // Arrange
        $validator = $this->createMock(RelativeRadianValidator::class);
        $validator->expects($this->exactly(2))->method("validate");
        $generator = new RelativeRadianGenerator(
            $this->trickFakerToGetTrueOut(),
            $validator,
            new RadianRange(RadianRange::min(), RadianRange::max())
        );

        // Act 
        $radian = $generator->generate();

        // Assert
        $this->assertInstanceOf(Radian::class, $radian);
        $this->assertGreaterThanOrEqual(0, $radian->value());

        /**
         * Relative range
         * Negative outcome
         */
        // Arrange
        $validator = $this->createMock(RelativeRadianValidator::class);
        $validator->expects($this->exactly(2))->method("validate");
        $generator = new RelativeRadianGenerator(
            $this->trickFakerToGetFalseOut(),
            $validator,
            new RadianRange(RadianRange::min(), RadianRange::max())
        );

        // Act
        $radian = $generator->generate();

        // Assert
        $this->assertInstanceOf(Radian::class, $radian);
        $this->assertLessThan(0, $radian->value());
    }
}