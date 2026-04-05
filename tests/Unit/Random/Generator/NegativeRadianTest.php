<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeRadian as NegativeRadianValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The NegativeRadian random generator")]
#[CoversClass(NegativeRadianGenerator::class)]
#[UsesClass(Radian::class)]
#[UsesClass(RadianRange::class)]
class NegativeRadianTest extends TestCase
{
    #[TestDox("generates a negative random Radian.")]
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

        // Act & Assert
        $this->assertInstanceOf(Radian::class, $generator->generate());
    }
}