<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The AngularDistanceRange")]
#[CoversClass(AngularDistanceRange::class)]
class AngularDistanceRangeTest extends TestCase
{
    #[TestDox("has a limit to the higher range extreme.")]
    public function test_max(): void
    {
        // Act & Assert
        $this->assertSame(
            NextFloat::before(SexadecimalAngularDistance::MAX),
            AngularDistanceRange::max()
        );
    }

    #[TestDox("has a limit to the lower range extreme.")]
    public function test_min(): void
    {
        // Act & Assert
        $this->assertSame(
            NextFloat::after(SexadecimalAngularDistance::MIN),
            AngularDistanceRange::min()
        );
    }
}