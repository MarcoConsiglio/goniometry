<?php
namespace MarcoConsiglio\Goniometry\Builders\Angle;

use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Builders\Builder;
use MarcoConsiglio\Goniometry\Builders\Traits\CalcOrderForSexagesimals;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;

/**
 *  Build an `Angle` starting from a `string` sexagesimal value.
 * 
 * @internal
 */
class FromString extends Builder
{
    use CalcOrderForSexagesimals;

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
        $this->checkParsingErrors();
    }

    /**
     * Parse an angle measure string and match degrees value.
     */
    protected function parseDegreesString(): void
    {
        $this->degrees_parsing_status = preg_match(AngularMeasure::DEGREES_REGEX, $this->measure, $this->degrees_match);
    }

    /**
     * Parse an angle measure string and match minutes value.
     */
    protected function parseMinutesString(): void
    {
        $this->minutes_parsing_status = preg_match(AngularMeasure::MINUTES_REGEX, $this->measure, $this->minutes_match);
    }

    /**
     * Parse an angle measure string and match seconds value.
     */
    protected function parseSecondsString(): void
    {
        $this->seconds_parsing_status = preg_match(AngularMeasure::SECONDS_REGEX, $this->measure, $this->seconds_match);
    }

    /**
     * Check if there are parsing error for degrees, minutes and seconds at 
     * the same time.
     * 
     * @throws NoMatchException when no value is recognized.
     */
    protected function checkParsingErrors(): void
    {
        if ($this->thereAreParsingErrors())
            throw new NoMatchException("Can't recognize the string $this->measure.");
    }

    protected function thereAreParsingErrors(): bool
    {
        return $this->degreesError() && $this->minutesError() && $this->secondsError();
    }

    /**
     * Return `true` if there was a parsing error on degrees or no degrees has been matched, `false` otherwise.
     */
    protected function degreesError(): bool
    {
        return $this->degrees_parsing_status == 0;
    }

    /**
     * Return `true` if there was a parsing error on minutes or no minutes has been matched, `false` otherwise.
     */
    protected function minutesError(): bool
    {
        return $this->minutes_parsing_status == 0;
    }

    /**
     * Return `true` if there was a parsing error on seconds or no seconds has been matched, `false` otherwise.
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
        if (! $this->degreesError())
            $this->degrees = new Degrees(
                abs((int) $this->degrees_match[1])
            );
        else $this->degrees = new Degrees(0);
    }

    /**
     * Calc minutes.
     */
    protected function calcMinutes(): void
    {
        if (! $this->minutesError())
            $this->minutes = new Minutes(
                $this->minutes_match[1]
            );
        else $this->minutes = new Minutes(0);
    }

    /**
     * Calc seconds.
     */
    protected function calcSeconds(): void
    {
        if (! $this->secondsError())
            $this->seconds = new Seconds(
                $this->seconds_match[1]
            );
        else $this->seconds = new Seconds(0);
    }

    /**
     * Calc sign.
     */
    protected function calcSign(): void
    {
        $this->direction = 
            $this->haveMinusSign() ?
            Rotation::CLOCKWISE :
            Rotation::COUNTER_CLOCKWISE;
    }

    /**
     * Return true if matched a negative degrees, false otherwise.+
     * 
     * @codeCoverageIgnore
     */
    protected function haveMinusSign(): bool
    {
        if (isset($this->degrees_match[1]))
            return str_contains((string) $this->degrees_match[1], '-');
        else return false;
    }

    /**
     * Fetches the data to build an `Angle`.
     *
     * @return array{SexagesimalDegrees,null,null}
     */
    public function fetchData(): array
    {
        $this->calcFromMostToLessSignificantValue();
        return [
            new SexagesimalDegrees(
                $this->degrees,
                $this->minutes,
                $this->seconds,
                $this->direction
            ),
            null, // Sexadecimal
            null  // Radian 
        ];
    }
}