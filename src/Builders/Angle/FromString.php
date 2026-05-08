<?php
namespace MarcoConsiglio\Goniometry\Builders\Angle;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;

/**
 *  Build an `Angle` starting from a `string` sexagesimal value.
 * 
 * @internal
 */
class FromString extends AngleBuilder
{
    /**
     * The parsing status for degrees value.
     */
    protected mixed $degrees_parsing_status;

    /**
     * The parsing status for minutes value.
     */
    protected mixed $minutes_parsing_status;

    /**
     * The parsing status for seconds value.
     */
    protected mixed $seconds_parsing_status;

    /**
     * The matched degrees by the regular expression.
     */
    protected array $degrees_match = [];

    /**
     * The matched minutes by the regular expression.
     */
    protected array $minutes_match = [];

    /**
     * The matched seconds by the regular expression.
     */
    protected array $seconds_match = [];

    /**
     * Construct an `AngleBuilder` with a sexagesimal string value.
     *
     * @param string $measure The string measure of an angle.
     * @throws NoMatchException when bad formatted angle is found.
     */
    public function __construct(    
        protected string $measure
    ) {    
        $this->parseDegreesString();
        $this->parseMinutesString();
        $this->parseSecondsString();
        $this->checkOverflow();
    }

    /**
     * Parse an angle measure string and match degrees value.
     */
    protected function parseDegreesString(): void
    {
        $this->degrees_parsing_status = preg_match(Angle::DEGREES_REGEX, $this->measure, $this->degrees_match);
    }

    /**
     * Parse an angle measure string and match minutes value.
     */
    protected function parseMinutesString(): void
    {
        $this->minutes_parsing_status = preg_match(Angle::MINUTES_REGEX, $this->measure, $this->minutes_match);
    }

    /**
     * Parse an angle measure string and match seconds value.
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
     * Return `true` if there was a parsing error on degrees, `false` otherwise.
     */
    protected function degreesError(): bool
    {
        return $this->degrees_parsing_status == 0;
    }

    /**
     * Return `true` if there was a parsing error on minutes, `false` otherwise.
     */
    protected function minutesError(): bool
    {
        return $this->minutes_parsing_status == 0;
    }

    /**
     * Return `true` if there was a parsing error on seconds, `false` otherwise.
     */
    protected function secondsError(): bool
    {
        return $this->seconds_parsing_status == 0;
    }

    /**
     * Calc degrees.
     */
    protected function calcDegrees(): void
    {
        $this->degrees = new Degrees(
            abs((int) $this->degrees_match[1])
        );
    }

    /**
     * Calc minutes.
     */
    protected function calcMinutes(): void
    {
        $this->minutes = new Minutes(
            $this->minutes_match[1]
        );
    }

    /**
     * Calc seconds.
     */
    protected function calcSeconds(): void
    {
        $this->seconds = new Seconds(
            $this->seconds_match[1]
        );
    }

    /**
     * Calc sign.
     */
    protected function calcSign(): void
    {
        $this->direction = 
            $this->haveMinusSign() ?
            Direction::CLOCKWISE :
            Direction::COUNTER_CLOCKWISE;
    }

    /**
     * Return true if matched a negative degrees, false otherwise.+
     * 
     * @codeCoverageIgnore
     */
    protected function haveMinusSign(): bool
    {
        return str_contains((string) $this->degrees_match[1], '-');
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