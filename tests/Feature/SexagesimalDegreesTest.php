<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The SexadecimalDegrees class")]
#[CoversClass(SexagesimalDegrees::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesTrait(WithAngleFaker::class)]
class SexagesimalDegreesTest extends TestCase
{
    protected SexagesimalDegrees $sexagesimal;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->sexagesimal = new SexagesimalDegrees(
            $this->randomDegrees(),
            $this->randomMinutes(),
            $this->randomSeconds(),
            $this->randomDirection()
        );
    }

    #[TestDox("has the \"degrees\" property which is a Degrees type.")]
    public function test_degrees(): void
    {
        // Act & Assert
        $this->assertInstanceOf(Degrees::class, $this->sexagesimal->degrees);
    }

    #[TestDox("has the \"minutes\" property which is a Minutes type.")]
    public function test_minutes(): void
    {
        // Act & Assert
        $this->assertInstanceOf(Minutes::class, $this->sexagesimal->minutes);
    }

    #[TestDox("has the \"seconds\" property which is a Seconds type.")]
    public function test_seconds(): void
    {   
        // Act & Assert
        $this->assertInstanceOf(Seconds::class, $this->sexagesimal->seconds);
    }
}