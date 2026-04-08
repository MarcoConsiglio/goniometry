<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveRadian as PositiveRadianValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(PositiveRadianGenerator::class)]
#[UsesClass(Radian::class)]
#[UsesClass(RadianRange::class)]
class PositiveRadianTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(PositiveRadianValidator::class);
        $validator->expects($this->once())->method("validate");
        $generator = new PositiveRadianGenerator(
            self::$faker,
            $validator,
            new RadianRange(0.0, RadianRange::max())
        );

        // Act
        $radian = $generator->generate();

        // Assert
        $this->assertInstanceOf(Radian::class, $radian);
        $this->assertGreaterThanOrEqual(0, $radian->value());
    }
}