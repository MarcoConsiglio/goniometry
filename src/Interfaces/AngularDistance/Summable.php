<?php
namespace MarcoConsiglio\Goniometry\Interfaces\AngularDistance;

use MarcoConsiglio\Goniometry\AngularMeasure;

interface Summable
{
  /**
   * The sum between two `AngularMeasure`s. The resulting angle can be positive or negative.
   */
  public function sum(AngularMeasure $addend): static;
}