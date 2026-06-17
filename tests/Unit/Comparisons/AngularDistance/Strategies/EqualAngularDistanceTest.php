<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal as AngleFromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\Traits\WithEqualComparisonDispositionTesting;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies\TestCase as StrategiesTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(EqualAngularDistance::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularMeasure::class)]
#[UsesClass(AngleFromSexagesimal::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
class EqualAngularDistanceTest extends StrategiesTestCase
{
    use WithEqualComparisonDispositionTesting;

    protected string $comparison = '=';


    public function test_compare(): void
    {
        $this->testEqualComparison(4);
    }

    /**
     * Return a comparison dataset with different and equal arguments.
     */
    protected function getComparisonDataset(): array
    {
        $d1 = 30; $d2 = 90; $m1 = 20; $m2 = 30; $s1 = 10; $s2 = 50;
        $r1 = Rotation::COUNTER_CLOCKWISE; $r2 = Rotation::CLOCKWISE;
        return [
            0 => [
                self::DIFFERENT => [$d1, $d2],
                self::EQUAL => [$d1, $d1]
            ],
            1 => [
                self::DIFFERENT => [$m1, $m2],
                self::EQUAL => [$m1, $m1]
            ],
            2 => [
                self::DIFFERENT => [$s1, $s2],
                self::EQUAL => [$s1, $s1]
            ],
            3 => [
                self::DIFFERENT => [$r1, $r2],
                self::EQUAL => [$r1, $r1]
            ]
        ];
    }

    /**
     * Construct the two records to be compared with some `$property_couples` 
     * representing an equal or different property comparison result.
     */
    protected function getRecordsToCompare(array $property_couples): array
    {
        $alfa = 0; $beta = 1;
        return [
            AngularDistance::createFromValues(
                $property_couples[0][$alfa],
                $property_couples[1][$alfa],
                $property_couples[2][$alfa],
                $property_couples[3][$alfa],
            ),
            AngularDistance::createFromValues(
                $property_couples[0][$beta],
                $property_couples[1][$beta],
                $property_couples[2][$beta],
                $property_couples[3][$beta],
            )
        ];
    }

    /**
     * Test two objects are equal. This is a Parameterized Test.
     * 
     * @param AngularDistance[] $objects An array of two `Angle` that will be fed to the comparison method.
     */
    protected function testObjectsAreEqual(int $case_number, array $objects): void
    {
        $this->assertTrue(
            new EqualAngularDistance($objects[0], $objects[1])->compare(),
            $this->getComparisonFailureMessage($case_number, $objects)    
        );
    }

    /**
     * Test two objects are different. This is a Parameterized Test.
     * 
     * @param int $case_number The case number being tested.
     * @param AngularDistance[] $objects An array of two `Angle` that will be fed to the comparison method.
     */
    protected function testObjectsAreNotEqual(int $case_number, array $objects): void
    {
        $this->assertFalse(
            new EqualAngularDistance($objects[0], $objects[1])->compare(),
            $this->getComparisonFailureMessage($case_number, $objects)
        );
    }
}