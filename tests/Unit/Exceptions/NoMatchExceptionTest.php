<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Exceptions;

use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("A NoMatchException")]
#[CoversClass(NoMatchException::class)]
class NoMatchExceptionTest extends TestCase
{
    #[TestDox("tells you're trying to create an angle from a bad formatted angle string.")]
    public function test_no_match_exception()
    {
        // Arrange
        $message = " does not match an angle measure.";
        $angle = "361° 72' 88\"";
        
        // Act
        $exception = new NoMatchException($angle);
        $actual_message = $exception->getMessage();

        // Assert
        $this->assertIsString($actual_message);
        $this->assertEquals($angle.$message, $actual_message);
    }
}