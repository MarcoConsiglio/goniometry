<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Radian class")]
#[CoversClass(Radian::class)]
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
            $value, $actual = $radian->value->toFloat(),
            "$value ≠ $actual"    
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
            $value, $actual = $radian->value->toFloat(),
            "$value ≠ $actual"    
        );
    }
}