<?php
namespace MarcoConsiglio\Goniometry\Tests;

use Error;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Interfaces\SexadecimalValue;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngle;
use MarcoConsiglio\Goniometry\Tests\Traits\WithFailureMessage;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;use RoundingMode;

class TestCase extends PHPUnitTestCase
{
    use WithFailureMessage, WithAngleFaker;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
    }

    /**
     * Convert a `$sexadecimal` value to sexagesimal values.
     * 
     * @return array{Degrees,Minutes,Seconds,Rotation}
     */
    protected function toSexagesimal(float $sexadecimal): array
    {
        $direction = $sexadecimal >= 0 ? Rotation::COUNTER_CLOCKWISE : Rotation::CLOCKWISE;
        $sexadecimal = new SexadecimalAngle(abs($sexadecimal));
        $degrees = new Degrees($sexadecimal->value->floor());
        $sexadecimal = new SexadecimalAngle($sexadecimal->value->abs()->sub($degrees->value));
        $minutes = new Minutes($sexadecimal->value->mul(Minutes::MAX)->floor());
        $sexadecimal = new SexadecimalAngle($sexadecimal->value->abs()->mul(Minutes::MAX)->sub($minutes->value));
        $seconds = new Seconds($sexadecimal->value->mul(Seconds::MAX));
        return [$degrees, $minutes, $seconds, $direction];
    }

    /**
     * Assert `$expected` `Degrees` are equal to `$actual` `Degrees`.
     */
    protected function assertDegrees(
        Degrees $expected, 
        Degrees $actual, 
        string $message = ""
    ): void {
        $this->assertEquals($expected->value(), $actual->value(), $message);
    }
    
    /**
     * Assert `$expected` `Minutes` are equal to `$actual` `Minutes`.
     */    
    protected function assertMinutes(
        Minutes $expected, 
        Minutes $actual, 
        string $message = ""
    ): void {
        $this->assertEquals($expected->value(), $actual->value(), $message);
    }

    /**
     * Assert `$expected` `Seconds` are equal to `$actual` `Seconds`.
     */        
    protected function assertSeconds(
        Seconds $expected, 
        Seconds $actual, 
        int|null $precision = null, 
        string $message = ""
    ): void {
        $this->assertEquals(
            $expected->value($precision), 
            $actual->value($precision), 
            $message
        );
    }

    /**
     * Assert `$expected` `Rotation` are equal to `$actual` `Rotation`.
     */    
    protected function assertDirection(
        Rotation $expected, 
        Rotation $actual, 
        string $message = ""
    ): void {
        $this->assertEquals($expected, $actual, $message);
    }

    /**
     * Assert `$expected` `SexadecimalValue` are equal to `$actual` `SexadecimalValue`.
     */    
    protected function assertSexadecimalDegrees(
        SexadecimalValue $expected,
        SexadecimalValue $actual,
        int $precision = PHP_FLOAT_DIG,
        string $message = ''
    ): void {
        $this->assertEquals(
            $expected->value($precision),
            $actual->value($precision),
            $message
        );
    }

    /**
     * Check if `$class`exists.
     * 
     * @throws Error if `$class` do not exist.
     */
    protected function checkClassExists(string $class): void
    {
        if (! class_exists($class)) throw new Error("$class class doesn't exist.");
    }

    /**
     * @throws Error because `$class` is not an allowed class.
     */
    protected function throwNotAllowedClassError(string $class): void
    {
        throw new Error("$class is not an allowed class.");
    }
}