<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Types;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Different;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Greater;
use MarcoConsiglio\Goniometry\Comparisons\Angle\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\Angle\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\FloatType;
use MarcoConsiglio\Goniometry\SexadecimalAngle;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Types\TestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(FloatType::class)]
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
            SexadecimalAngle::MIN,
            SexadecimalAngle::MAX
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
    }
}