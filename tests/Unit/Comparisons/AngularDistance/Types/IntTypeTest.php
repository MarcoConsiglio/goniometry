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
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\IntType;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(IntType::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(DifferentInt::class)]
#[UsesClass(EqualInt::class)]
#[UsesClass(GreaterInt::class)]
#[UsesClass(GreaterOrEqualInt::class)]
#[UsesClass(LesserInt::class)]
#[UsesClass(LesserOrEqualInt::class)]
#[UsesTrait(WithAngleFaker::class)]
class IntTypeTest extends TestCase
{
    #[Override]
    protected function getBeta(): int
    {
        return $this->randomInteger(
            AngularDistance::MIN, 
            AngularDistance::MAX
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