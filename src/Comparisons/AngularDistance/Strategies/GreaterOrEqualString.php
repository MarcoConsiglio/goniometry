<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualString as AngleGreaterOrEqualString;
use Override;

class GreaterOrEqualString extends AngleGreaterOrEqualString
{
    #[Override]
    public function compare(): bool
    {
        return 
            new EqualString($this->alfa, $this->beta)->compare() ||
            new GreaterString($this->alfa, $this->beta)->compare();
    }
}