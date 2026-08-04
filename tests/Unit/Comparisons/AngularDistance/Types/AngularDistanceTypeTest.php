<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Types;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\AngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Different;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Equal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Greater;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\LesserOrEqual;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Types\TestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Stub;

#[CoversClass(AngularDistanceType::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(DifferentAngularDistance::class)]
#[UsesClass(EqualAngularDistance::class)]
#[UsesClass(EqualAngularDistance::class)]
#[UsesClass(GreaterAngularDistance::class)]
#[UsesClass(GreaterOrEqualAngularDistance::class)]
#[UsesClass(LesserAngularDistance::class)]
#[UsesClass(LesserOrEqualAngularDistance::class)]
class AngularDistanceTypeTest extends TestCase
{
    #[Override]
    protected function getBeta(): AngularDistance&Stub
    {
        return $this->createStub(AngularDistance::class);
    }

    #[Override]
    protected function getInputTypeClass(): string
    {
        return AngularDistanceType::class;
    }

    public function test_getStrategyFor(): void
    {
        $this->testInputType(Equal::class,          EqualAngularDistance::class);
        $this->testInputType(Different::class,      DifferentAngularDistance::class);
        $this->testInputType(Greater::class,        GreaterAngularDistance::class);
        $this->testInputType(GreaterOrEqual::class, GreaterOrEqualAngularDistance::class);
        $this->testInputType(Lesser::class,         LesserAngularDistance::class);
        $this->testInputType(LesserOrEqual::class,  LesserOrEqualAngularDistance::class);
        $this->testInputTypeError();
    }
}