<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;

/**
 * Build an `AngularDistance` starting from two `Angle`s.
 */
class FromAngles extends FromSexadecimal
{
    /**
     * Construct the `FromAngles` `AngleBuilder`.
     */
    public function __construct(protected Angle $alfa, protected Angle $beta) {}

    /**
     * Check for overflow above/below ±360°.
     * 
     * @codeCoverageIgnore
     */
    #[Override]
    protected function checkOverflow(): void
    { /* No need to check overflow. Overflow is allowed. */ } 

    /**
     * Calcs degrees.
     */
    #[Override]
    protected function calcDegrees(): void
    { parent::calcDegrees(); } 

    /**
     * Calcs minutes.    
     */
    #[Override]
    protected function calcMinutes(): void
    { parent::calcMinutes(); } 

    /**
     * Calcs seconds.
     */
    #[Override]
    protected function calcSeconds(): void
    { parent::calcSeconds(); } 

    /**
     * Calcs direction.
     */
    #[Override]
    protected function calcSign(): void
    { parent::calcSign(); } 

    /**
     * Fetch data to build an `AngularDistance` class.
     * 
     * @return array{SexagesimalDegrees,SexadecimalAngularDistance,null}
     */
    #[Override]
    public function fetchData(): array
    {
        $distance_1 = $this->alfa->toSexadecimalDegrees()->value->sub(
            $this->beta->toSexadecimalDegrees()->value
        )->abs();
        $distance_2 = new Number(Degrees::MAX)->sub($distance_1);
        $this->decimal = new SexadecimalAngularDistance(
            Number::min($distance_1, $distance_2)
        );
        return parent::fetchData();
    }
}