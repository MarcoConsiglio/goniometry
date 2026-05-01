<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders\AngularDistance;

use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(FromSexadecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
class FromSexadecimalTest extends TestCase
{
    public function test_create_from_in_range_positive_sexadecimal_degrees(): void
    {
        /**
         * Float input
         */
        // Arrange
        $float = $this->positiveRandomSexadecimal(max: 180, precision: 3);
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($float);

        // Act
        [$sexagesimal, $sexadecimal] = new FromSexadecimal($float)->fetchData();

        // Assert
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection($direction, $sexagesimal->direction);

        /**
         * SexadecimalAngularDistance input
         */
        // Arrange
        $float = $this->positiveRandomSexadecimal(max: 180, precision: 3);
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($float);

        // Act
        [$sexagesimal, $sexadecimal] = new FromSexadecimal(
            $sexadecimal_input = new SexadecimalAngularDistance($float)
        )->fetchData();

        // Assert
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection($direction, $sexagesimal->direction);
        $this->assertEquals($sexadecimal_input->value(3), $sexadecimal->value(3));
    }

    public function test_create_from_in_range_negative_sexadecimal_degrees(): void
    {
        /**
         * Float input
         */
        // Arrange
        $float = $this->negativeRandomSexadecimal(min: -180, precision: 3);
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($float);

        // Act
        [$sexagesimal, $sexadecimal] = new FromSexadecimal($float)->fetchData();

        // Assert
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection($direction, $sexagesimal->direction);

        /**
         * SexadecimalAngularDistance input
         */
        // Arrange
        $float = $this->negativeRandomSexadecimal(min: -180, precision: 3);
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($float);

        // Act
        [$sexagesimal, $sexadecimal] = new FromSexadecimal(new SexadecimalAngularDistance($float))->fetchData();

        // Assert
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection($direction, $sexagesimal->direction);        
    }
}