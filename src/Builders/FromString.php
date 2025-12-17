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
     * The matched degrees by the regular expression.
     *
     * @var array
     */
    protected array $degrees_match = [];

    /**
     * The matched minutes by the regular expression.
     *
     * @var array
     */
    protected array $minutes_match = [];

    /**
     * The matched seconds by the regular expression.
     *
     * @var array
     */
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
     * @throws RegExFailureException Error while parsing with a regular expression.
     */
    protected function parseDegreesString()
    {
        $this->degrees_parsing_status = preg_match(Angle::DEGREES_REGEX, $this->measure, $this->degrees_match);
    }

    /**
     * Parse an angle measure string and match minutes value.
     *
     * @param string $angle The string format angle value.
     * @return void
     * @throws \MarcoConsiglio\Goniometry\Exceptions\NoMatchException Bad formatted angle is found.
     * @throws RegExFailureException Error while parsing with a regular expression.
     */
    protected function parseMinutesString()
    {
        $this->minutes_parsing_status = preg_match(Angle::MINUTES_REGEX, $this->measure, $this->minutes_match);
    }

    /**
     * Parse an angle measure string and match seconds value.
     *
     * @param string $angle The string format angle value.
     * @return void
     * @throws \MarcoConsiglio\Goniometry\Exceptions\NoMatchException Bad formatted angle is found.
     * @throws RegExFailureException Error while parsing with a regular expression.
     */
    protected function parseSecondsString()
    {
        $this->seconds_parsing_status = preg_match(Angle::SECONDS_REGEX, $this->measure, $this->seconds_match);
    }

    /**
     * Check for overflow above/below +/-360°.
     *
     * @return void
     * @throws \MarcoConsiglio\Goniometry\Exceptions\NoMatchException when a bad formatted angle is matched.
     */
    protected function checkOverflow()
    {
        if ($this->degrees_parsing_status == 0 || 
            $this->minutes_parsing_status == 0 ||
            $this->seconds_parsing_status == 0
        ) {
            throw new NoMatchException("Can't recognize the string $this->measure.");
        }
    }//@codeCoverageIgnore

    /**
     * Calc degrees.
     *
     * @return void
     */
    protected function calcDegrees()
    {
        $this->degrees = abs((int) $this->degrees_match[1]);
    }

    /**
     * Calc minutes.
     *
     * @return void
     */
    protected function calcMinutes()
    {
        $this->minutes = (int) $this->minutes_match[1];
    }

    /**
     * Calc seconds.
     *
     * @return void
     */
    protected function calcSeconds()
    {
        $this->seconds = $this->seconds_match[1];
    }

    /**
     * Calc sign.
     *
     * @return void
     */
    protected function calcSign()
    {
        $this->direction = ((int) $this->degrees_match[1]) >= 0 ? Angle::COUNTER_CLOCKWISE : Angle::CLOCKWISE;
    }

    /**
     * Fetches the data to build an Angle.
     *
     * @return array{
     *      int,
     *      int,
     *      float,
     *      int,
     *      int|null,
     *      float|null,
     *      int|null,
     *      float|null,
     *      int|null
     *  }
     */
    public function fetchData(): array
    {
        $this->calcDegrees();
        $this->calcMinutes();
        $this->calcSeconds();
        $this->calcSign();
        return [
            $this->degrees,
            $this->minutes,
            $this->seconds,
            $this->direction,
            null, // No suggested decimal precision
            null, // No original decimal value
            Angle::countDecimalPlaces($this->seconds),
            null, // No original radian value 
            null, // No original radian precision
        ];
    }
}