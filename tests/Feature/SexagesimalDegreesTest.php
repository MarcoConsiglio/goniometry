<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The SexadecimalDegrees class")]
#[CoversClass(SexagesimalDegrees::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class SexagesimalDegreesTest extends TestCase
{
    #[TestDox("has the \"degrees\" property which is a Degrees type.")]
    public function test_degrees(): void
    {
        // Arrange
        $sexadecimal = new SexagesimalDegrees(
            new Degrees($this->randomDegrees()),
            new Minutes($this->randomMinutes()),
            new Seconds($this->randomSeconds()),
            $this->randomDirection()
        );

        // Act & Assert
        $this->assertInstanceOf(Degrees::class, $sexadecimal->degrees);
    }

    #[TestDox("has the \"minutes\" property which is a Minutes type.")]
    public function test_minutes(): void
    {
        // Arrange
        $sexadecimal = new SexagesimalDegrees(
            new Degrees($this->randomDegrees()),
            new Minutes($this->randomMinutes()),
            new Seconds($this->randomSeconds()),
            $this->randomDirection()
        );

        // Act & Assert
        $this->assertInstanceOf(Minutes::class, $sexadecimal->minutes);
    }

    #[TestDox("has the \"seconds\" property which is a Seconds type.")]
    public function test_seconds(): void
    {
        // Arrange
        $sexadecimal = new SexagesimalDegrees(
            new Degrees($this->randomDegrees()),
            new Minutes($this->randomMinutes()),
            new Seconds($this->randomSeconds()),
            $this->randomDirection()
        );

        // Act & Assert
        $this->assertInstanceOf(Seconds::class, $sexadecimal->seconds);
    }
}