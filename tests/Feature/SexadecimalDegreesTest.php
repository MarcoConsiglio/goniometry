<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use RoundingMode;

#[TestDox("The SexadecimalDegrees class")]
#[CoversClass(SexadecimalDegrees::class)]
class SexadecimalDegreesTest extends TestCase
{
    #[TestDox("stores a sexadecimal value.")]
    public function test_value(): void
    {
        // Arrange
        $value = $this->randomSexadecimal();
        $sexadecimal = new SexadecimalDegrees($value);

        // Act & Assert
        $this->assertEquals(
            $this->safeRound($value),
            $sexadecimal->value(self::PRECISION)
        );
    }
}