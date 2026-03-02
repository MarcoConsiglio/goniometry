<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Interfaces\AngleBuilder as AngleBuilderInterface;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use Marcoconsiglio\ModularArithmetic\ModularNumber;
use RoundingMode;

/**
 * Represents an angle builder.
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