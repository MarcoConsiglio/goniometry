<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(SecondsRange::class)]
class SecondsRangeTest extends TestCase
{
    public function test_max(): void
    {
        // Act & Assert
        $this->assertEquals(NextFloat::before(Seconds::MAX), SecondsRange::max());
    }
}