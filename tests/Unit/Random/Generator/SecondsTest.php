<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Seconds random generator")]
#[CoversClass(SecondsGenerator::class)]
#[UsesClass(SecondsRange::class)]
#[UsesClass(Seconds::class)]
class SecondsTest extends TestCase
{
    #[TestDox("generates a random seconds value.")]
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(SecondsValidator::class);
        $validator->expects($this->once())->method("validate");
        $generator = new SecondsGenerator(
            self::$faker,
            $validator,
            new SecondsRange(
                SecondsRange::MIN,
                SecondsRange::max()
            )
        );

        // Act & Assert
        $this->assertInstanceOf(Seconds::class, $generator->generate());
    }
}