<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The RadianRange")]
#[CoversClass(RadianRange::class)]
class RadianRangeTest extends TestCase
{
    #[TestDox("has a limit to the higher range extreme.")]
    public function test_max(): void
    {
        // Act & Assert
        $this->assertSame(
            NextFloat::before(Radian::MAX),
            RadianRange::max()
        );
    }

    #[TestDox("has a limit to the lower range extreme.")]
    public function test_min(): void
    {
        // Act & Assert
        $this->assertSame(
            NextFloat::after(-Radian::MAX),
            RadianRange::min()
        );
    }
}