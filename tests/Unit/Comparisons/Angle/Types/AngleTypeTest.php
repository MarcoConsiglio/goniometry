<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Different;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Greater;
use MarcoConsiglio\Goniometry\Comparisons\Angle\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\Angle\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\AngleType;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Types\TestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Stub;

#[CoversClass(AngleType::class)]
#[UsesClass(Different::class)]
#[UsesClass(DifferentAngle::class)]
#[UsesClass(Equal::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(Greater::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(GreaterOrEqual::class)]
#[UsesClass(GreaterOrEqualAngle::class)]
#[UsesClass(Lesser::class)]
#[UsesClass(LesserAngle::class)]
#[UsesClass(LesserOrEqual::class)]
#[UsesClass(LesserOrEqualAngle::class)]
class AngleTypeTest extends TestCase
{
    #[Override]
    protected function getBeta(): Angle&Stub
    {
        return $this->createStub(Angle::class);
    }

    #[Override]
    protected function getInputTypeClass(): string
    {
        return AngleType::class;
    }

    public function test_getStrategyFor(): void
    {
        $this->testInputType(Equal::class, EqualAngle::class);
        $this->testInputType(Different::class, DifferentAngle::class);
        $this->testInputType(Greater::class, GreaterAngle::class);
        $this->testInputType(GreaterOrEqual::class, GreaterOrEqualAngle::class);
        $this->testInputType(Lesser::class, LesserAngle::class);
        $this->testInputType(LesserOrEqual::class, LesserOrEqualAngle::class);
        $this->testInputTypeError();
    }
}