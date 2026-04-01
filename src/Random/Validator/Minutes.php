<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Integer\Validator;
use MarcoConsiglio\Goniometry\Minutes as AngleMinutes;

class Minutes extends Validator
{
    public function validate(int &$min, int &$max): void
    {
        $this->avoidNegativeValues($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    protected function avoidNegativeValues(float &$min, float &$max): void
    {
        if ($this->isNegative($min)) $this->setMin($min);
        if ($this->isNegative($max)) $this->setMax($max);
    }

    protected function avoidExceedingValues(float &$min, float &$max): void
    {
        if ($this->greaterThanOrEqual($min, AngleMinutes::MAX)) $this->setMin($min);        
        if ($this->greaterThanOrEqual($max, AngleMinutes::MAX)) $this->setMax($max);
    }

    protected function setMin(int &$value): void
    {
        $value = 0;
    }

    protected function setMax(int &$value): void
    {
        $value = AngleMinutes::MAX - 1;
    }
}