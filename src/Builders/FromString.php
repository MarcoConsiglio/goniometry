<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use MarcoConsiglio\Goniometry\Exceptions\RegExFailureException;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;

/**
 *  Builds an angle starting from a string value.
 */
class FromString extends AngleBuilder
{
    /**
     * The string measure of an Angle.
     *
     * @var string
     */
    protected string $measure;

    /**
     * The parsing status for degrees value.
     *
     * @var mixed
     */
    protected mixed $degrees_parsing_status;

    /**
     * The parsing status for minutes value.
     *
     * @var mixed
     */
    protected mixed $minutes_parsing_status;

    /**
     * The parsing status for seconds value.
     *
     * @var mixed
     */
    protected mixed $seconds_parsing_status;

    /**
     * The regex matches.
     *
     * @var array
     * @deprecated
     */
    protected array $matches = [];

    protected array $degrees_match = [];
    protected array $minutes_match = [];
    protected array $seconds_match = [];

    /**
     * Builds an AngleBuilder with a string value.
     *
     * @param string $measure
     * @return void
     */
    public function __construct(string $measure)
    {    
        $this->measure = $measure;
        $this->parseDegreesString($this->measure);
        $this->parseMinutesString($this->measure);
        $this->parseSecondsString($this->measure);
        $this->checkOverflow();
    }

    /**
     * Parse an angle measure string and match degrees value.
     *
     * @param string $angle The string format angle value.
     * @return void
     * @throws \MarcoConsiglio\Goniometry\Exceptions\NoMatchException Bad formatted angle is found.
     * @throws \MarcoConsiglio\Goniometry\Exceptions\RegExFailureException Error while parsing with a regular expression.
     */
    protected function parseDegreesString(string $angle)
    {
        $this->degrees_parsing_status = preg_match(Angle::DEGREES_REGEX, $angle, $this->degrees_match);
    }

    /**
     * Parse an angle measure string and match minutes value.
     *
     * @param string $angle The string format angle value.
     * @return void
     * @throws \MarcoConsiglio\Goniometry\Exceptions\NoMatchException Bad formatted angle is found.
     * @throws \MarcoConsiglio\Goniometry\Exceptions\RegExFailureException Error while parsing with a regular expression.
     */
    protected function parseMinutesString(string $angle)
    {
        $this->minutes_parsing_status = preg_match(Angle::MINUTES_REGEX, $angle, $this->minutes_match);
    }

    /**
     * Parse an angle measure string and match seconds value.
     *
     * @param string $angle The string format angle value.
     * @return void
     * @throws \MarcoConsiglio\Goniometry\Exceptions\NoMatchException Bad formatted angle is found.
     * @throws \MarcoConsiglio\Goniometry\Exceptions\RegExFailureException Error while parsing with a regular expression.
     */
    protected function parseSecondsString(string $angle)
    {
        $this->seconds_parsing_status = preg_match(Angle::SECONDS_REGEX, $angle, $this->seconds_match);
    }

    /**
     * Check for overflow above/below +/-360°.
     *
     * @return void
     * @throws \MarcoConsiglio\Goniometry\Exceptions\NoMatchException when a bad formatted angle is matched.
     * @throws \MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException when the matched angle overflows +/-360°.
     */
    public function checkOverflow()
    {
        if ($this->degrees_parsing_status == 0 || 
            $this->minutes_parsing_status == 0 ||
            $this->seconds_parsing_status == 0
        ) {
            throw new NoMatchException("Can't recognize the string $this->measure.");
        }
        // The Angle::REGEX is a bit buggy. It accepts degrees greater than 360°.
        // if ($this->matches[2] > 360) {
        //     throw new AngleOverflowException("The angle degrees can't be greater than 360°.");
        // }
    }

    /**
     * Calc degrees.
     *
     * @return void
     */
    public function calcDegrees()
    {
        $this->degrees = abs((int) $this->degrees_match[1]);
    }

    /**
     * Calc minutes.
     *
     * @return void
     */
    public function calcMinutes()
    {
        $this->minutes = (int) $this->minutes_match[1];
    }

    /**
     * Calc seconds.
     *
     * @return void
     */
    public function calcSeconds()
    {
        $this->seconds = $this->seconds_match[1];
    }

    /**
     * Calc sign.
     *
     * @param mixed $data
     * @return void
     */
    public function calcSign()
    {
        $this->direction = ((int) $this->degrees_match[1]) >= 0 ? Angle::COUNTER_CLOCKWISE : Angle::CLOCKWISE;
    }

    /**
     * Fetches the data to build an Angle.
     *
     * @return array
     */
    public function fetchData(): array
    {
        $this->calcDegrees();
        $this->calcMinutes();
        $this->calcSeconds();
        $this->calcSign();
        return parent::fetchData();
    }
}