<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualFloat as AngleLesserOrEqualFloat;
use Override;

class LesserOrEqualFloat extends AngleLesserOrEqualFloat
{
    public function __construct(AngularDistance $alfa, float $beta, int $precision = 54)
    {
        parent::__construct($alfa, $beta, $precision);
    }

    #[Override]
    public function compare(): bool
    {
        return 
            new EqualFloat($this->alfa, $this->beta, $this->precision)->compare() ||
            new LesserFloat($this->alfa, $this->beta, $this->precision)->compare();
    }
}