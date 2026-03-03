<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\Types\ComparisonType;
use MarcoConsiglio\Goniometry\Comparisons\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\Types\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Types\IntType;
use MarcoConsiglio\Goniometry\Comparisons\Types\StringType;

abstract class Comparison
{
    protected Angle $alfa;

    protected string|int|float|Angle $beta;

    protected Strategy $comparison_strategy;

    public function __construct(Angle $alfa, string|int|float|Angle $beta)
    {
        $this->alfa = $alfa;
        $this->beta = $beta;
        $this->setComparisonStrategy();
    }

    protected function getBetaType(): InputType
    {
        if ($this->beta instanceof Angle) {
            return new AngleType($this->beta);
        }
        switch (gettype($this->beta)) {
            case 'int':
                return new IntType($this->beta);
                break;
            case 'string':
                return new StringType($this->beta);
                break;
            case 'double':
                return new FloatType;
                break;
        }
    }

    abstract protected function setComparisonStrategy(): void;

    abstract public function compare(): bool;
}