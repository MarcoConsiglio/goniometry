<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Types;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualInt as AngleEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\IntType;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\InputType;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Types\InputTypeTestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\MockObject\Stub;

#[TestDox("The AngularDistance\Types\IntType ")]
#[CoversClass(IntType::class)]
#[UsesClass(AngleEqualInt::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(DifferentInt::class)]
#[UsesTrait(WithAngleFaker::class)]
class IntTypeTest extends InputTypeTestCase
{
    protected AngularDistance&Stub $alfa;

    protected int $beta;

    protected InputType $input_type;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa = $this->createStub(AngularDistance::class);
        $this->beta = $this->randomDegrees()->value();
        $this->input_type = new IntType($this->beta);
    }

    #[TestDox("return the strategy for an Equal comparison.")]
    public function test_equal_strategy(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(Equal::class), 
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(EqualInt::class, $strategy);
    }    

    #[TestDox("return the strategy for a Different comparison.")]
    public function test_different_strategy(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(Different::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(DifferentInt::class, $strategy);
    }
}