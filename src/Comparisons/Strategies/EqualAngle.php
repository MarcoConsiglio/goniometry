<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

class EqualAngle extends ComparisonStrategy
{
    private bool $equal_sign;

    private bool $equal_degrees;

    private bool $equal_minutes;

    private bool $equal_seconds;

    public function __construct(Angle $alfa, protected Angle $beta)
    {
        parent::__construct($alfa);
        $this->equal_sign = $this->alfa->direction == $this->beta->direction;
        $this->equal_degrees = $this->alfa->degrees->eq($this->beta->degrees);
        $this->equal_minutes = $this->alfa->minutes->eq($this->beta->minutes);
        $this->equal_seconds = $this->alfa->seconds->eq($this->beta->seconds);
    }

    public function compare(): bool
    {
        if (! $this->equal_sign) return false;
        if (! $this->equal_degrees) return false;
        if (! $this->equal_minutes) return false;
        if (! $this->equal_seconds) return false;
        return true;
    }
}