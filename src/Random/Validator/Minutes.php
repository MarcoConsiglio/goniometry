<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Integer\Validator;
use MarcoConsiglio\Goniometry\Random\MinutesRange;

class Minutes extends Validator
{
    /**
     * Validate the range.
     */
    public function validate(int &$min, int &$max): void
    {
        $this->avoidNegativeValues($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    /**
     * Avoid negative values.
     */
    protected function avoidNegativeValues(int &$min, int &$max): void
    {
        if ($this->isNegative($min)) $this->setMin($min);
        if ($this->isNegative($max)) $this->setMax($max);
    }

    /**
     * Avoid values ​​that go beyond the permitted limit.
     */
    protected function avoidExceedingValues(int &$min, int &$max): void
    {
        if ($this->greaterThanOrEqual($min, MinutesRange::MAX)) $this->setMin($min);        
        if ($this->greaterThanOrEqual($max, MinutesRange::MAX)) $this->setMax($max);
    }

    /**
     * Set the minimum allowed value.
     */
    protected function setMin(int &$value): void
    {
        $value = MinutesRange::MIN;
    }

    /**
     * Set the maximum allowed value.
     */
    protected function setMax(int &$value): void
    {
        $value = MinutesRange::MAX;
    }
}