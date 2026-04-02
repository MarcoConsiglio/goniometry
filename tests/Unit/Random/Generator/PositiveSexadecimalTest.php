<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(SexadecimalRange::class)]
class PositiveSexadecimalTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(PositiveSexadecimalValidator::class);
        $validator->expects($this->once())->method("validate");
        $generator = new PositiveSexadecimalGenerator(
            self::$faker,
            $validator,
            new SexadecimalRange(0, SexadecimalRange::max())
        );

        // Act & Assert
        $this->assertIsFloat($generator->generate());
    }
}