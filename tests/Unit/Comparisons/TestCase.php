<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons;

use MarcoConsiglio\Goniometry\Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    abstract protected function testComparison(string $class): void;
}