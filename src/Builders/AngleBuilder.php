<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Interfaces\AngleBuilder as AngleBuilderInterface;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;

/**
 * Represents an `Angle` builder.
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
    protected Direction $direction = Direction::COUNTER_CLOCKWISE;  

    /**
     * Check for overflow above/below ±360°.
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