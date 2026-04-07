<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\FloatGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveRadian as PositiveRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Radian as RadianValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(FloatGenerator::class)]
#[UsesClass(PositiveRadianGenerator::class)]
#[UsesClass(PositiveRadianValidator::class)]
#[UsesClass(Radian::class)]
#[UsesClass(RadianGenerator::class)]
#[UsesClass(RadianRange::class)]
#[UsesClass(RadianValidator::class)]
class FloatGeneratorTest extends TestCase
{
    #[TestDox("normalize precision to be inside 0 to PHP_FLOAT_DIG range.")]
    public function test_normalize_precision(): void
    {
        /**
         * Precision higher than PHP_FLOAT_DIG
         */
        // Arrange
        $generator = new PositiveRadianGenerator(
            self::$faker,
            new PositiveRadianValidator,
            new RadianRange(RadianRange::min(), RadianRange::max())
        );

        // Act
        $radian = $generator->generate(
            $this->positiveRandomInteger(min: PHP_FLOAT_DIG + 1)
        );

        // Assert
        $this->assertEquals(PHP_FLOAT_DIG, $radian->value->scale);

        /**
         * Precision lower or equal to PHP_FLOAT_DIG
         */
        // Arrange
        $generator = new PositiveRadianGenerator(
            self::$faker,
            new PositiveRadianValidator,
            new RadianRange(RadianRange::min(), RadianRange::max())
        );

        // Act
        $radian = $generator->generate(
            $precision = $this->positiveRandomInteger(max: PHP_FLOAT_DIG)
        );

        // Assert
        $this->assertEquals($precision, $radian->value->scale);
    }
}