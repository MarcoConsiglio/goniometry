<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\MinutesRange;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Minutes random generator")]
#[CoversClass(MinutesGenerator::class)]
class MinutesTest extends TestCase
{
    #[TestDox("generates a random minutes value.")]
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(MinutesValidator::class);
        $validator->expects($this->once())->method("validate");
        $generator = new MinutesGenerator(
            self::$faker,
            $validator,
            new MinutesRange(
                MinutesRange::MIN,
                MinutesRange::MAX 
            )
        );

        // Act & Assert
        $this->assertIsInt($generator->generate());
    }
}