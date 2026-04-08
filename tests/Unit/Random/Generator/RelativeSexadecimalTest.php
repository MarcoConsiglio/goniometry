<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
class RelativeSexadecimalTest extends GeneratorTestCase
{
    public function test_random_generation(): void
    {
        /**
         * Positive range
         */
        // Arrange
        $generator = new RelativeSexadecimalGenerator(
            self::$faker,
            new RelativeSexadecimalValidator,
            new SexadecimalRange(0, SexadecimalRange::max())
        );

        // Act & Assert
        $this->assertIsFloat($generator->generate());

        /**
         * Negative range
         */
        // Arrange
        $generator = new RelativeSexadecimalGenerator(
            self::$faker,
            new RelativeSexadecimalValidator,
            new SexadecimalRange(SexadecimalRange::min(), NextFloat::beforeZero())
        );

        // Act & Assert
        $this->assertIsFloat($generator->generate());

        /**
         * Relative range
         * Positive outcome
         */
        // Arrange
        $generator = new RelativeSexadecimalGenerator(
            $this->trickFakerToGetTrueOut(),
            new RelativeSexadecimalValidator,
            new SexadecimalRange(
                SexadecimalRange::min(), 
                SexadecimalRange::max()),
        );

        // Act
        $number = $generator->generate();

        // Assert
        $this->assertIsFloat($number);
        $this->assertGreaterThanOrEqual(0, $number);

        /**
         * Relative range
         * Negative outcome
         */
        // Arrange
        $generator = new RelativeSexadecimalGenerator(
            $this->trickFakerToGetFalseOut(),
            new RelativeSexadecimalValidator,
            new SexadecimalRange(
                SexadecimalRange::min(), 
                SexadecimalRange::max()
            )
        );

        // Act
        $number = $generator->generate();

        // Assert
        $this->assertIsFloat($number);
        $this->assertLessThan(0, $number);
    }
}