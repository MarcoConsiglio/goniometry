<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Comparison as ComparisonBetweenAngle;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Comparison as ComparisonBetweenAngularDistance;
use MarcoConsiglio\Goniometry\Tests\TestCase as BaseTestCase;
use Override;

abstract class TestCase extends BaseTestCase
{
    abstract protected function testComparison(string $class): void;
}