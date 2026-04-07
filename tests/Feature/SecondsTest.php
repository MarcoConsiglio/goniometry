<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as GeneratorSeconds;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The Seconds type")]
#[CoversClass(Seconds::class)]
#[UsesTrait(WithAngleFaker::class)]
#[UsesClass(GeneratorSeconds::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesClass(SecondsRange::class)]
class SecondsTest extends TestCase
{
    protected Seconds $a;

    protected Seconds $b;

    protected Seconds $c;

    protected function setUp(): void
    {
        parent::setUp();
        $this->a = $this->randomSeconds(min: 30, precision: 1);
        $this->b = clone $this->a;
        $this->c = $this->randomSeconds(max: NextFloat::before(30), precision: 1);
    }

    #[TestDox("stores the measurement of seconds.")]
    public function test_seconds_value(): void
    {
        // Arrange
        $expected_value = $this->randomSeconds(precision: 1)->value();
        $degrees = new Seconds($expected_value);

        // Act & Assert
        $this->assertEquals($expected_value, $degrees->value());
    }

    #[TestDox("can be casted to string.")]
    public function test_cast_to_string(): void
    {
        // Arrange
        $expected_value = $this->randomSeconds(precision: 3)->value();
        $seconds = new Seconds($expected_value);

        // Act & Assert
        $this->assertEquals("{$expected_value}\"", (string) $seconds);
    }

    #[TestDox("can be compared with another instance of the same type.")]
    public function test_comparison_between_seconds(): void
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