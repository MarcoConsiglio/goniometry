<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualString as AngleGreaterOrEqualString;
use Override;

class GreaterOrEqualString extends AngleGreaterOrEqualString
{
    public function __construct(AngularDistance $alfa, string $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        return 
            new EqualString($this->alfa, $this->beta)->compare() ||
            new GreaterString($this->alfa, $this->beta)->compare();
    }
}