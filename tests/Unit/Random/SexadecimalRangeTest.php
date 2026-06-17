<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;


#[CoversClass(SexadecimalRange::class)]
class SexadecimalRangeTest extends TestCase
{
    public function test_max(): void
    {
        // Act & Assert
        $this->assertSame(
            NextFloat::before(Degrees::MAX),
            SexadecimalRange::max()
        );
    }

    public function test_min(): void
    {
        // Act & Assert
        $this->assertSame(
            NextFloat::after(-Degrees::MAX),
            SexadecimalRange::min()
        );
    }
}