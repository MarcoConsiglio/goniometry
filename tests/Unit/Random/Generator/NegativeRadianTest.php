<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\RadianAngle;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeRadian as NegativeRadianValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(NegativeRadianGenerator::class)]
#[UsesClass(RadianAngle::class)]
#[UsesClass(RadianRange::class)]
class NegativeRadianTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(NegativeRadianValidator::class);
        $validator->expects($this->once())->method("validate");
        $generator = new NegativeRadianGenerator(
            self::$faker,
            $validator,
            new RadianRange(RadianRange::min(), NextFloat::beforeZero())
        );

        // Act 
        $radian = $generator->generate();

        // Assert
        $this->assertInstanceOf(RadianAngle::class, $radian);
        $this->assertLessThan(0, $radian->value());
    }
}