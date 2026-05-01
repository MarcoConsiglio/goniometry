<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The SexadecimalAngularDistance")]
#[CoversClass(SexadecimalAngularDistance::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesTrait(WithAngleFaker::class)]
class SexadecimalAngularDistanceTest extends TestCase
{
    protected SexadecimalAngularDistance $sexadecimal;

    protected float $value;
    
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->sexadecimal = new SexadecimalAngularDistance(
            $this->value = $this->randomSexadecimal(
                min: NextFloat::after(SexadecimalAngularDistance::MIN),
                max: NextFloat::before(SexadecimalAngularDistance::MAX),
                precision: 3
            )
        );
    }

    #[TestDox("stores a sexadecimal value.")]
    public function test_value(): void
    {
        // Act & Assert
        $this->assertEquals(
            $this->value, $this->sexadecimal->value()
        );
    }

    #[TestDox("can be casted to string.")]
    public function test_cast_to_string(): void
    {
        // Act & Assert
        $this->assertEquals(
            "{$this->value}°", "{$this->sexadecimal}"
        );
    }
}