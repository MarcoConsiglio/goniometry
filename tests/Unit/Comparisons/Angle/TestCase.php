<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Comparison;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\TestCase as ComparisonsTestCase;
use Override;

abstract class TestCase extends ComparisonsTestCase
{
    protected Angle $alfa;
    
    protected Angle $beta;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa = $this->randomAngle();
        $this->beta = $this->randomAngle();
    }

    protected function testComparison(string $class): void
    {
        $this->checkClassExists($class);
        if (is_subclass_of($class, Comparison::class)) {
            /**
             * Beta is an Angle
             */
            // Arrange
            $comparison = new $class($this->alfa, $this->beta);

            // Act & Assert
            $this->assertIsBool($comparison->compare());

            /**
             * Beta is a string
             */
            // Arrange
            $comparison = new $class($this->alfa, (string) $this->beta);

            // Act & Assert
            $this->assertIsBool($comparison->compare());

            /**
             * Beta is an int
             */
            // Arrange
            $comparison = new $class($this->alfa, $this->beta->degrees->value());

            // Act & Assert
            $this->assertIsBool($comparison->compare());

            /**
             * Beta is a float
             */
            // Arrange
            $comparison = new $class($this->alfa, $this->beta->toFloat());
            $comparison->setPrecision(55);
            $comparison->setPrecision($this->randomPrecision());

            // Act & Assert
            $this->assertIsBool($comparison->compare());
            
        } else $this->throwNotAllowedClassError($class);
    }

}