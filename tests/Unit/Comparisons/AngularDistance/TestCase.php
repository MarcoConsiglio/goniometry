<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Comparison;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\TestCase as ComparisonsTestCase;
use Override;

abstract class TestCase extends ComparisonsTestCase
{
    protected AngularDistance $alfa;
    
    protected AngularDistance $beta;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa = $this->randomAngularDistance();
        $this->beta = $this->randomAngularDistance();
    }

    protected function testComparison(string $class): void
    {
        $this->checkClassExists($class);
        if (is_subclass_of($class, Comparison::class)) {
            /**
             * Beta is an AngularDistance
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