<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\AngleBuilder as AngleBuilderInterface;
use RoundingMode;

/**
 * Represents an angle builder.
 */
abstract class AngleBuilder implements AngleBuilderInterface
{
    /**
     * Degrees value.
     *
     * @var integer
     */
    protected int $degrees = 0;

    /**
     * Minutes value.
     *
     * @var integer
     */
    protected int $minutes = 0;

    /**
     * Seconds value.
     *
     * @var float
     */
    protected float $seconds = 0.0;

    /**
     * Rotation direction.
     *
     * @var integer
     */
    protected int $direction = Angle::COUNTER_CLOCKWISE;  

    /**
     * Check for overflow above/below ±360°.
     *
     * @return void
     */
    abstract protected function checkOverflow();

    /**
     * Calcs degrees.
     *
     * @return void
     */
    abstract protected function calcDegrees();

    /**
     * Calcs minutes.    
     *
     * @return void
     */
    abstract protected function calcMinutes();

    /**
     * Calcs seconds.
     *
     * @return void
     */
    abstract protected function calcSeconds();

    /**
     * Calcs direction.
     *
     * @return void
     */
    abstract protected function calcSign();

    /**
     * Fetch data to build an Angle class.
     *
     * @return array
     */
    abstract public function fetchData(): array;
}