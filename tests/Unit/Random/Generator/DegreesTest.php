<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Random\DegreesRange;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(DegreesGenerator::class)]
#[UsesClass(Degrees::class)]
class DegreesTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(DegreesValidator::class);
        $validator->expects($this->once())->method("validate");
        $generator = new DegreesGenerator(
            self::$faker,
            $validator,
            new DegreesRange(
                DegreesRange::MIN, 
                DegreesRange::MAX
            )
        );

        // Act & Assert
        $this->assertInstanceOf(Degrees::class, $generator->generate());
    }
}