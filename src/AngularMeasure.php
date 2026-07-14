<?php
namespace MarcoConsiglio\Goniometry;

use MarcoConsiglio\Goniometry\Builders\Angle\AngleBuilder;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Interfaces\Angle;
use MarcoConsiglio\Goniometry\Interfaces\RadianValue;
use MarcoConsiglio\Goniometry\Interfaces\SexadecimalValue;
use Stringable;

/**
 * The concept of an angular measure.
 */
abstract class AngularMeasure implements Angle, Stringable
{
    /**
     * Construct an `AngularMeasure`.
     */
    protected function __construct(AngleBuilder $builder)
    {
        [
            $this->sexagesimal,
            $this->sexadecimal,
            $this->radian
        ] = $builder->fetchData();
    }

    /**
     * Regular expression used to parse degrees value as integer number.
     */
    public const DEGREES_REGEX = "/(?<!\d)(-?(?:360|3[0-5]\d|[12]?\d{1,2}))°/";

    /**
     * Regular expression used to parse minutes value as integer number.
     */
    public const MINUTES_REGEX = '/\b([0-5]?\d)\'/';

    /**
     * Regular expression used to parse second value as decimal number.
     */
    public const SECONDS_REGEX = '/\b((?:[1-5]?\d)(?:\.\d+)?)"/';

    /**
     * The degrees part.
     */
    public Degrees $degrees {
        get {return $this->sexagesimal->degrees;}
    }

    /**
     * The minutes part.
     */
    public Minutes $minutes {
        get {return $this->sexagesimal->minutes;}
    }

    /**
     * The seconds part.
     */
    public Seconds $seconds {
        get {return $this->sexagesimal->seconds;}
    }

    
    /** 
     * The `Angle` `Rotation` direction.
    */
    public Rotation $direction {
        get {return $this->sexagesimal->direction;}
    }

    /**
     * The sexagesimal value of this `Angle`.
     */
    protected SexagesimalDegrees $sexagesimal;
    
    /** 
     * The sexadecimal degrees value of this `Angle`.
     */
    protected SexadecimalValue|null $sexadecimal = null;

    /** 
     * The radian value of this `Angle`.
     */
    protected RadianValue|null $radian = null;
}