<?php
namespace MarcoConsiglio\Goniometry\Tests\Traits;

trait WithEqualComparisonDispositionTesting
{
    use WithDispositionTesting;

    /**
     * Test two objects are equal. This is a Parameterized Test.
     * 
     * @param int $case_number The case number being tested.
     * @param array $records An array of two records that will be fed to the comparison method.
     */
    abstract protected function testObjectsAreEqual(int $case_number, array $objects): void;
    // {
    //     $this->assertObjectEquals($objects[0], $objects[1], "equals", 
    //         $this->getComparisonFailureMessage($case_number, $objects)
    //     );
    // }

    /**
     * Test two objects are different. This is a Parameterized Test.
     * 
     * @param int $case_number The case number being tested.
     * @param array $objects An array of two objects that will be fed to the comparison method.
     */
    abstract protected function testObjectsAreNotEqual(int $case_number, array $objects): void;
    // {
    //     $this->assertObjectNotEquals($objects[0], $objects[1], "equals", 
    //         $this->getComparisonFailureMessage($case_number, $objects)
    //     );
    // }
}