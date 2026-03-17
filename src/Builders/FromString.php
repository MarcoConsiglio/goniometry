<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Exceptions\RegExFailureException;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;

/**
 *  Builds an `Angle` starting from a string value.
 */
class FromString extends AngleBuilder
{
    /**
     * The string measure of an angle.
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
     * Construct an `AngleBuilder` with a sexagesimal string value.
     *
     * @throws NoMatchException when bad formatted angle is found.
     * @throws RegExFailureException while failing to parse text with a regular
     * expression.
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
     * @param string $angle The string format angle value (sexagesimal).
     * @throws NoMatchException when bad formatted angle is found.
     * @throws RegExFailureException while failing to parse text with a regular
     * expression.
     */
    protected function parseDegreesString(): void
    {
        $this->degrees_parsing_status = preg_match(Angle::DEGREES_REGEX, $this->measure, $this->degrees_match);
    }

    /**
     * Parse an angle measure string and match minutes value.
     *
     * @param string $angle The string format angle value.
     * @throws NoMatchException when bad formatted angle is found.
     * @throws RegExFailureException while failing to parse text with a regular
     * expression.
     */
    protected function parseMinutesString(): void
    {
        $this->minutes_parsing_status = preg_match(Angle::MINUTES_REGEX, $this->measure, $this->minutes_match);
    }

    /**
     * Parse an angle measure string and match seconds value.
     *
     * @param string $angle The string format angle value.
     * @throws NoMatchException when bad formatted angle is found.
     * @throws RegExFailureException while failing to parse text with a regular
     * expression.
     */
    protected function parseSecondsString(): void
    {
        $this->seconds_parsing_status = preg_match(Angle::SECONDS_REGEX, $this->measure, $this->seconds_match);
    }

    /**
     * Check for overflow above/below +/-360°.
     * 
     * @throws NoMatchException when a bad formatted angle is matched.
     */
    protected function checkOverflow(): void
    {
        if ($this->degreesError())
            throw new NoMatchException("Can't recognize the string $this->measure.");
        if ($this->minutesError())
            throw new NoMatchException("Can't recognize the string $this->measure.");
        if ($this->secondsError())
            throw new NoMatchException("Can't recognize the string $this->measure.");
    }

    /**
     * Return true if there was a parsing error on degrees.
     */
    protected function degreesError(): bool
    {
        return $this->degrees_parsing_status == 0;
    }

    /**
     * Return true if there was a parsing error on minutes.
     */
    protected function minutesError(): bool
    {
        return $this->minutes_parsing_status == 0;
    }

    /**
     * Return true if there was a parsing error on seconds.
     */
    protected function secondsError(): bool
    {
        return $this->seconds_parsing_status == 0;
    }

    /**
     * Calc degrees.
     *
     * @return void
     */
    protected function calcDegrees(): void
    {
        $this->degrees = new Degrees(
            abs((int) $this->degrees_match[1])
        );
    }

    /**
     * Calc minutes.
     *
     * @return void
     */
    protected function calcMinutes(): void
    {
        $this->minutes = new Minutes(
            $this->minutes_match[1]
        );
    }

    /**
     * Calc seconds.
     *
     * @return void
     */
    protected function calcSeconds(): void
    {
        $this->seconds = new Seconds(
            $this->seconds_match[1]
        );
    }

    /**
     * Calc sign.
     *
     * @return void
     */
    protected function calcSign(): void
    {
        $this->direction = ((int) $this->degrees_match[1]) >= 0 ? Direction::COUNTER_CLOCKWISE : Direction::CLOCKWISE;
    }

    /**
     * Fetches the data to build an `Angle`.
     *
     * @return array{SexagesimalDegrees,null,null}
     */
    public function fetchData(): array
    {
        $this->calcDegrees();
        $this->calcMinutes();
        $this->calcSeconds();
        $this->calcSign();
        return [
            new SexagesimalDegrees(
                $this->degrees,
                $this->minutes,
                $this->seconds,
                $this->direction
            ),
            null,
            null
        ];
    }
}