<?php
namespace MarcoConsiglio\Goniometry\Builders\Angle;

use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Interfaces\AngleBuilder as AngleBuilderInterface;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;

/**
 * Represents an `Interfaces\Angle` builder.
 * 
 * @internal
 */
abstract class AngleBuilder implements AngleBuilderInterface
{
    /**
     * Degrees value.
     */
    protected Degrees $degrees;

    /**
     * Minutes value.
     */
    protected Minutes $minutes;

    /**
     * Seconds value.
     */
    protected Seconds $seconds;

    /**
     * Rotation direction.
     */
    protected Rotation $direction = Rotation::COUNTER_CLOCKWISE;  

    /**
     * Check for overflow above/below ±360° or check bad formatted string.
     */
    abstract protected function checkOverflow(): void;

    /**
     * Calcs degrees.
     */
    abstract protected function calcDegrees(): void;

    /**
     * Calcs minutes.    
     */
    abstract protected function calcMinutes(): void;

    /**
     * Calcs seconds.
     */
    abstract protected function calcSeconds(): void;

    /**
     * Calcs direction.
     */
    abstract protected function calcSign(): void;

    /**
     * Fetch data to build an Angle class.
     */
    abstract public function fetchData(): array;
}