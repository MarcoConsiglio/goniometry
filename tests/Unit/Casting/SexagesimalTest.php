<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Casting;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Sexagesimal class")]
#[CoversClass(Sexagesimal::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Cast::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
class SexagesimalTest extends TestCase
{
    #[TestDox("normalize precision to be inside 0 to PHP_FLOAT_DIG range.")]
    public function test_normalize_precision(): void
    {
        /**
         * Precision higher than PHP_FLOAT_DIG
         */
        // Arrange
        $caster = new Cast(
            Angle::createFromDecimal($sexadecimal = new SexadecimalDegrees("180.012345678901234567890123456"))   
        );

        // Assert
        $this->assertEquals($sexadecimal->value(), $caster->cast());

        /**
         * Precision lower or equal to PHP_FLOAT_DIG
         */
        // Arrange
        $caster = new Cast(
            Angle::createFromDecimal($sexadecimal = new SexadecimalDegrees("180.0123"))               
        );

        // Assert
        $this->assertEquals($sexadecimal->value(), $caster->cast());
    }
}