<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The SecondsRange")]
#[CoversClass(SecondsRange::class)]
class SecondsRangeTest extends TestCase
{
    #[TestDox("has a limit to the higher range extreme.")]
    public function test_max(): void
    {
        // Act & Assert
        $this->assertEquals(NextFloat::before(Seconds::MAX), SecondsRange::max());
    }
}