<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Integer\Validator;
use MarcoConsiglio\Goniometry\Degrees as AngleDegrees;
use MarcoConsiglio\Goniometry\Random\DegreesRange;

/**
 * Validate a random degrees range.
 */
class Degrees extends Validator
{
    public function validate(int &$min, int &$max): void
    {
        $this->avoidNegativeValues($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    protected function avoidNegativeValues(int &$min, int &$max): void
    {
        if ($this->isNegative($min)) $this->setMin($min);
        if ($this->isNegative($max)) $this->setMax($max);
    }

    protected function avoidExceedingValues(int &$min, int &$max): void
    {
        if ($this->greaterThanOrEqual($min, AngleDegrees::MAX)) $this->setMin($min);        
        if ($this->greaterThanOrEqual($max, AngleDegrees::MAX)) $this->setMax($max);
    }

    protected function setMin(int &$value): void
    {
        $value = DegreesRange::MIN;
    }

    protected function setMax(int &$value): void
    {
        $value = DegreesRange::MAX;
    }
}