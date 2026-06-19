<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Degrees;
use Override;

class EqualAngularDistance extends EqualAngle
{
    public function __construct(AngularDistance $alfa, AngularDistance $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        if ($this->bothAre180()) return true;
        if (! $this->rotationDirectionsAreEqual()) return false;
        if (! $this->secondsAreEqual()) return false;
        if (! $this->minutesAreEqual()) return false;
        return $this->degreesAreEqual();
    }

    protected function rotationDirectionsAreEqual(): bool
    {
        return $this->alfa->direction === $this->beta->direction;
    }

    protected function bothAre180(): bool
    {
        return 
            $this->alfa->degrees->eq(new Degrees(180)) &&
            $this->beta->degrees->eq(new Degrees(180));
    }
}