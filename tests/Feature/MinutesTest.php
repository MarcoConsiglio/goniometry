<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The Minutes type")]
#[CoversClass(Minutes::class)]
#[UsesTrait(WithAngleFaker::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesValidator::class)]
class MinutesTest extends TestCase
{
    protected Minutes $a;

    protected Minutes $b;

    protected Minutes $c;

    protected function setUp(): void
    {
        parent::setUp();
        $this->a = $this->randomMinutes(min: 30);
        $this->b = clone $this->a;
        $this->c = $this->randomMinutes(max: 29);
    }

    #[TestDox("stores the measurement of minutes.")]
    public function test_minutes_value(): void
    {
        // Arrange
        $expected_value = $this->randomMinutes()->value();
        $degrees = new Minutes($expected_value);

        // Act & Assert
        $this->assertEquals($expected_value, $degrees->value());
    }

    #[TestDox("can be casted to string.")]
    public function test_cast_to_string(): void
    {
        // Arrange
        $expected_value = $this->randomMinutes()->value();
        $minutes = new Minutes($expected_value);

        // Act & Assert
        $this->assertEquals("{$expected_value}'", (string) $minutes);
    }

    #[TestDox("can be compared with another instance of the same type.")]
    public function test_comparison_between_minutes(): void
    {
        /**
         * Equal comparison
         */
        $this->assertTrue($this->a->eq($this->b));
        $this->assertFalse($this->a->eq($this->c));

        /**
         * Different comparison
         */
        $this->assertTrue($this->a->not($this->c));
        $this->assertFalse($this->a->not($this->b));

        /**
         * Greater than comparison
         */
        $this->assertTrue($this->a->gt($this->c));
        $this->assertFalse($this->c->gt($this->a));

        /**
         * Greater than or equal comparison
         */
        $this->assertTrue($this->a->gte($this->c));
        $this->assertTrue($this->a->gte($this->b));
        $this->assertFalse($this->c->gte($this->a));

        /**
         * Less than comparison
         */
        $this->assertTrue($this->c->lt($this->a));
        $this->assertFalse($this->a->lt($this->c));

        /**
         * Less than or equal comparison
         */
        $this->assertTrue($this->c->lte($this->a));
        $this->assertTrue($this->a->lte($this->b));
        $this->assertFalse($this->a->lte($this->c));
    }
}