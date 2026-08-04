<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Different;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Greater;
use MarcoConsiglio\Goniometry\Comparisons\Angle\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\Angle\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\IntType;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Types\TestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(IntType::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(DifferentInt::class)]
#[UsesClass(EqualInt::class)]
#[UsesClass(GreaterInt::class)]
#[UsesClass(GreaterOrEqualInt::class)]
#[UsesClass(LesserInt::class)]
#[UsesClass(LesserOrEqualInt::class)]
class IntTypeTest extends TestCase
{
    #[Override]
    protected function getBeta(): int
    {
        return $this->randomInteger(
            Angle::MIN,
            Angle::MAX
        );
    }

    #[Override]
    protected function getInputTypeClass(): string
    {
        return IntType::class;
    }

    public function test_getStrategyFor(): void
    {
        $this->testInputType(Equal::class, EqualInt::class);
        $this->testInputType(Different::class, DifferentInt::class);
        $this->testInputType(Greater::class, GreaterInt::class);
        $this->testInputType(GreaterOrEqual::class, GreaterOrEqualInt::class);
        $this->testInputType(Lesser::class, LesserInt::class);
        $this->testInputType(LesserOrEqual::class, LesserOrEqualInt::class);
        $this->testInputTypeError();
    }
}