<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Tests\Traits\WithDispositionTesting;
use MarcoConsiglio\Goniometry\Tests\Traits\WithEqualComparisonDispositionTesting;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The EqualAngle comparison strategy")]
#[CoversClass(EqualAngle::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class EqualAngleTest extends TestCase
{
    use WithEqualComparisonDispositionTesting;

    protected string $comparison = '=';
    
    #[TestDox("can compare two Angle instances.")]
    public function test_compare(): void
    {
        $this->testEqualComparison(3);
    }

    /**
     * Return a fail message for this TestCase.
     */
    protected function getFailMessage(Angle $alfa, int|float|string|Angle $beta): string
    {
        return $this->comparisonFail($alfa, $this->comparison, $beta);
    }

    /**
     * Return a comparison dataset with different and equal arguments.
     */
    protected function getComparisonDataset(): array
    {
        $d1 = 180; $d2 = 90; $m1 = 20; $m2 = 30; $s1 = 10; $s2 = 50;
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
            Angle::createFromValues(
                $property_couples[0][$alfa],
                $property_couples[1][$alfa],
                $property_couples[2][$alfa],
            ),
            Angle::createFromValues(
                $property_couples[0][$beta],
                $property_couples[1][$beta],
                $property_couples[2][$beta],
            )
        ];
    }

    /**
     * Test two objects are equal. This is a Parameterized Test.
     * 
     * @param Angle[] $objects An array of two `Angle` that will be fed to the comparison method.
     */
    protected function testObjectsAreEqual(int $case_number, array $objects): void
    {
        $this->assertTrue(
            new EqualAngle($objects[0], $objects[1])->compare(),
            $this->getComparisonFailureMessage($case_number, $objects)    
        );
    }

    /**
     * Test two objects are different. This is a Parameterized Test.
     * 
     * @param int $case_number The case number being tested.
     * @param Angle[] $objects An array of two `Angle` that will be fed to the comparison method.
     */
    protected function testObjectsAreNotEqual(int $case_number, array $objects): void
    {
        $this->assertFalse(
            new EqualAngle($objects[0], $objects[1])->compare(),
            $this->getComparisonFailureMessage($case_number, $objects)
        );
    }

}