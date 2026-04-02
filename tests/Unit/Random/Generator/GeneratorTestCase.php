<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use Faker\Generator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

abstract class GeneratorTestCase extends TestCase
{
    /**
     * Replace the `Faker\Generator` implementetion with one that return `true`
     * every time the `$boolean()` property is called.
     */
    protected function trickFakerToGetTrueOut(): Generator&MockObject
    {
        $builder = $this->getMockBuilder(Generator::class);
        $builder->onlyMethods(["__call"]);
        $faker_mock = $builder->getMock();
        $faker_mock->expects($this->atLeastOnce())->method("__call")->with("boolean")->willReturn(true);
        return $faker_mock;
    }

    /**
     * Replace the `Faker\Generator` implementetion with one that return `false`
     * every time the `$boolean()` property is called.
     */
    protected function trickFakerToGetFalseOut(): Generator&MockObject
    {
        $builder = $this->getMockBuilder(Generator::class);
        $builder->onlyMethods(["__call"]);
        $faker_mock = $builder->getMock();
        $faker_mock->expects($this->atLeastOnce())->method("__call")->with("boolean")->willReturn(false);
        return $faker_mock;
    }
}