<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;


#[CoversClass(RadianRange::class)]
class RadianRangeTest extends TestCase
{
    public function test_max(): void
    {
        // Act & Assert
        $this->assertSame(
            NextFloat::before(Radian::MAX),
            RadianRange::max()
        );
    }

    public function test_min(): void
    {
        // Act & Assert
        $this->assertSame(
            NextFloat::after(Radian::MIN),
            RadianRange::min()
        );
    }
}