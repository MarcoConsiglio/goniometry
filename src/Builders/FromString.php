<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use MarcoConsiglio\Goniometry\Exceptions\RegExFailureException;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use RoundingMode;

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
     * @var int|false
     */
    protected mixed $degrees_parsing_status;

    /**
     * The parsing status for minutes value.
     *
     * @var int|false
     */
    protected mixed $minutes_parsing_status;

    /**
     * The parsing status for seconds value.
     *
     * @var int|false
     */
    protected mixed $seconds_parsing_status;

    /**
     * The matched values for degrees.
     *
     * @var array
     */
    protected array $degrees_match = [];

    /**
     * The matched values for minutes.
     *
     * @var array
     */
    protected array $minutes_match = [];

    /**
     * The matched values for seconds.
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
     * @throws \MarcoConsiglio\Goniometry\Exceptions\RegExFailureException Error while parsing with a regular expression.
     */
    protected function parseDegreesString(string $angle)
    {
        $regex = Angle::DEGREES_REGEX;
        $this->degrees_parsing_status = preg_match($regex, $angle, $this->degrees_match);
        if ($this->degrees_parsing_status === false) throw new RegExFailureException(
            $this->getRegExFailureMessage($regex)
        );
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
        $regex = Angle::MINUTES_REGEX;
        $this->minutes_parsing_status = preg_match($regex, $angle, $this->minutes_match);
        if ($this->minutes_parsing_status === false) throw new RegExFailureException(
            $this->getRegExFailureMessage($regex)
        );
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
        $regex = Angle::SECONDS_REGEX;
        $this->seconds_parsing_status = preg_match($regex, $angle, $this->seconds_match);
        if ($this->seconds_parsing_status === false) throw new RegExFailureException(
            $this->getRegExFailureMessage($regex)
        );
    }

    /**
     * Check if values overflow the maximum allowed.
     *
     * @return void
     * @throws \MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException when values overflows the maximum allowed.
     */
    public function checkOverflow()
    {
        if (isset($this->degrees_match[1])) $this->checkDegreesOverflow((int) $this->degrees_match[1]);
        if (isset($this->minutes_match[1])) $this->checkMinutesOverflow((int) $this->minutes_match[1]);
        if (isset($this->seconds_match[1])) $this->checkSecondsOverflow((float) $this->seconds_match[1]);
    }

    /**
     * Check if degrees overflow the maximum allowed.
     *
     * @param integer $degrees
     * @return void
     */
    private function checkDegreesOverflow(int $degrees)
    {
        $max_degrees = Angle::MAX_DEGREES;
        if (abs($degrees) > $max_degrees) throw new AngleOverflowException("The angle {$this->measure} exceeds {$max_degrees}°.");
    }

    /**
     * Check if minutes overflow the maximum allowed.
     *
     * @param integer $minutes
     * @return void
     */
    private function checkMinutesOverflow(int $minutes)
    {
        $max_minutes = Angle::MAX_MINUTES;
        if ($minutes >= $max_minutes) throw new AngleOverflowException("The angle {$this->measure} exceeds {$max_minutes}'.");
    }

    /**
     * Check if seconds overflow the maximum allowed.
     *
     * @param integer $degrees
     * @return void
     */
    private function checkSecondsOverflow(float $seconds)
    {
        $max_seconds = Angle::MAX_SECONDS;
        if (round($seconds, 1, RoundingMode::HalfTowardsZero) > 59.9) throw new AngleOverflowException("The angle {$this->measure} exceeds {$max_seconds}\".");
    }

    /**
     * Calc degrees.
     *
     * @return void
     */
    public function calcDegrees()
    {
        $this->degrees = isset($this->degrees_match[1]) ? 
            abs((int) $this->degrees_match[1]) : 0;
    }

    /**
     * Calc minutes.
     *
     * @return void
     */
    public function calcMinutes()
    {
        $this->minutes = isset($this->minutes_match[1]) ?
            (int) $this->minutes_match[1] : 0;
    }

    /**
     * Calc seconds.
     *
     * @return void
     */
    public function calcSeconds()
    {
        $this->seconds = isset($this->seconds_match[1]) ?
            $this->seconds_match[1] : 0;
    }

    /**
     * Calc sign.
     *
     * @param mixed $data
     * @return void
     */
    public function calcSign()
    {
        $this->direction = (substr($this->measure, 0, 1) == '-') ?
            Angle::CLOCKWISE : Angle::COUNTER_CLOCKWISE;
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

    /**
     * Produce an error message for a regular expression failure.
     *
     * @param string $regex
     * @return string
     */
    private function getRegExFailureMessage(string $regex): string
    {
        return "The regular expression {$regex} failed.";
    }
}