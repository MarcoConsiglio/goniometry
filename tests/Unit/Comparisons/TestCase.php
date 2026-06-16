<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Tests\TestCase as BaseTestCase;
use Override;

abstract class TestCase extends BaseTestCase
{
    protected Angle $alfa_angle;

    protected AngularDistance $alfa_angular_distance;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa_angle = $this->randomAngle();
        $this->alfa_angular_distance = $this->randomAngularDistance();
    }
    protected function testComparison(string $class): void
    {
        if (! class_exists($class)) throw new Error("$class class doesn't exist.");

        /**
         * Beta is an Angle
         */
        // Arrange
        $comparison = new $class($this->alfa_angle, $this->randomAngle());

        // Act & Assert
        $this->assertIsBool($comparison->compare());

        /**
         * Beta is a string
         */
        // Arrange
        $comparison = new $class($this->alfa_angle, (string) $this->randomAngle());

        // Act & Assert
        $this->assertIsBool($comparison->compare());

        /**
         * Beta is an int
         */
        // Arrange
        $comparison = new $class($this->alfa_angle, $this->randomAngle()->degrees->value());

        // Act & Assert
        $this->assertIsBool($comparison->compare());

        /**
         * Beta is a float
         */
        // Arrange
        $comparison = new $class($this->alfa_angle, $this->randomAngle()->toFloat());
        $comparison->setPrecision(55);
        $comparison->setPrecision($this->randomPrecision());

        // Act & Assert
        $this->assertIsBool($comparison->compare());

       /**
         * Beta is an AngularDistance
         */
        // Arrange
        $comparison = new $class($this->alfa_angular_distance, $this->randomAngularDistance());

        // Act & Assert
        $this->assertIsBool($comparison->compare());

        /**
         * Beta is a string
         */
        // Arrange
        $comparison = new $class($this->alfa_angular_distance, (string) $this->randomAngularDistance());

        // Act & Assert
        $this->assertIsBool($comparison->compare());

        /**
         * Beta is an int
         */
        // Arrange
        $comparison = new $class($this->alfa_angular_distance, $this->randomAngularDistance()->degrees->value());

        // Act & Assert
        $this->assertIsBool($comparison->compare());

        /**
         * Beta is a float
         */
        // Arrange
        $comparison = new $class($this->alfa_angular_distance, $this->randomAngularDistance()->toFloat());
        $comparison->setPrecision(55);
        $comparison->setPrecision($this->randomPrecision());

        // Act & Assert
        $this->assertIsBool($comparison->compare());
    }
}