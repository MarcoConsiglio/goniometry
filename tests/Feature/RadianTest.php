<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The Radian class")]
#[CoversClass(Radian::class)]
#[UsesTrait(WithAngleFaker::class)]
class RadianTest extends TestCase
{
    #[TestDox("can store a positive radian value.")]
    public function test_positive_radian(): void
    {
        // Arrange
        $value = $this->positiveRandomRadian();
        
        // Act
        $radian = new Radian($value);

        // Assert
        $this->assertEquals(
            $this->safeRound($value),
            $radian->value(self::PRECISION)
        );
    }

    #[TestDox("can store a negative radian value.")]
    public function test_negative_radian(): void
    {
        // Arrange
        $value = $this->negativeRandomRadian();

        // Act
        $radian = new Radian($value);

        // Assert
        $this->assertEquals(
            $this->safeRound($value), 
            $radian->value(self::PRECISION)   
        );
    }
}