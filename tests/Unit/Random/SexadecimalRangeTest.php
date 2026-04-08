<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The SexadecimalRange")]
#[CoversClass(SexadecimalRange::class)]
class SexadecimalRangeTest extends TestCase
{
    #[TestDox("has a limit to the higher range extreme.")]
    public function test_max(): void
    {
        // Act & Assert
        $this->assertSame(
            NextFloat::before(Degrees::MAX),
            SexadecimalRange::max()
        );
    }

    #[TestDox("has a limit to the lower range extreme.")]
    public function test_min(): void
    {
        // Act & Assert
        $this->assertSame(
            NextFloat::after(-Degrees::MAX),
            SexadecimalRange::min()
        );
    }
}