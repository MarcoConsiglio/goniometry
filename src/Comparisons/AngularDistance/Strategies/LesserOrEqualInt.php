<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualInt as AngleLesserOrEqualInt;
use Override;

class LesserOrEqualInt extends AngleLesserOrEqualInt
{
    public function __construct(AngularDistance $alfa, int $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        return 
            new EqualInt($this->alfa, $this->beta)->compare() ||
            new LesserInt($this->alfa, $this->beta)->compare();
    }
}