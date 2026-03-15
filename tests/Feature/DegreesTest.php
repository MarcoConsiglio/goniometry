<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Degrees type")]
#[CoversClass(Degrees::class)]
class DegreesTest extends TestCase
{
    protected Degrees $a;

    protected Degrees $b;

    protected Degrees $c;

    protected function setUp(): void
    {
        parent::setUp();
        $this->a = new Degrees($this->randomDegrees(min: 180));
        $this->b = clone $this->a;
        $this->c = new Degrees($this->randomDegrees(max: 179));
    }

    #[TestDox("stores the measurement of degrees.")]
    public function test_degrees_value(): void
    {
        // Arrange
        $expected_value = $this->randomDegrees();
        $degrees = new Degrees($expected_value);

        // Act & Assert
        $this->assertEquals($expected_value, $degrees->value());
    }

    #[TestDox("can be casted to string.")]
    public function test_cast_to_string(): void
    {
        // Arrange
        $expected_value = $this->randomDegrees();
        $degrees = new Degrees($expected_value);

        // Act & Assert
        $this->assertEquals("{$expected_value}°", (string) $degrees);
    }

    #[TestDox("can be compared with another instance of the same type.")]
    public function test_comparison_between_degrees(): void
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