<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Interfaces\AngularMeasureBuilder;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;

/**
 * Represents an `Interfaces\Angle` builder.
 * 
 * @internal
 */
abstract class Builder implements AngularMeasureBuilder
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
     * Fetch data to build an Angle class.
     */
    abstract public function fetchData(): array;
}