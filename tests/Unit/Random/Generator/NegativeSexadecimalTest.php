<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(SexadecimalRange::class)]
class NegativeSexadecimalTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(NegativeSexadecimalValidator::class);
        $validator->expects($this->once())->method("validate");
        $generator = new NegativeSexadecimalGenerator(
            self::$faker,
            $validator,
            new SexadecimalRange(SexadecimalRange::min(), SexadecimalRange::max())
        );

        // Act & Assert
        $this->assertIsFloat($generator->generate());
    }
}