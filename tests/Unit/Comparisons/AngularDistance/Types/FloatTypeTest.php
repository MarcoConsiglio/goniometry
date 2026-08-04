<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Types;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Different;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Equal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Greater;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\FloatType;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(FloatType::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(DifferentFloat::class)]
#[UsesClass(EqualFloat::class)]
#[UsesClass(GreaterFloat::class)]
#[UsesClass(GreaterOrEqualFloat::class)]
#[UsesClass(LesserFloat::class)]
#[UsesClass(LesserOrEqualFloat::class)]
class FloatTypeTest extends TestCase
{
    #[Override]
    protected function getBeta(): float
    {
        return $this->randomFloat(
            AngularDistance::MIN, 
            AngularDistance::MAX
        );
    }

    #[Override]
    protected function getInputTypeClass(): string
    {
        return FloatType::class;
    }

    public function test_getStrategyFor(): void
    {
        $this->testInputType(Equal::class, EqualFloat::class);
        $this->testInputType(Different::class, DifferentFloat::class);
        $this->testInputType(Greater::class, GreaterFloat::class);
        $this->testInputType(GreaterOrEqual::class, GreaterOrEqualFloat::class);
        $this->testInputType(Lesser::class, LesserFloat::class);
        $this->testInputType(LesserOrEqual::class, LesserOrEqualFloat::class);
        $this->testInputTypeError();
    }
}