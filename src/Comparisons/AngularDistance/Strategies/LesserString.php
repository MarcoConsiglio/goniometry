<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserString as AngleLesserString;
use Override;

class LesserString extends AngleLesserString
{
    public function __construct(AngularDistance $alfa, string $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        return new LesserAngularDistance(
            $this->alfa,
            AngularDistance::createFromString($this->beta)
        )->compare();
    }
}