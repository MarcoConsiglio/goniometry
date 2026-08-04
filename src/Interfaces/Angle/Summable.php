<?php
namespace MarcoConsiglio\Goniometry\Interfaces\Angle;

use MarcoConsiglio\Goniometry\AngularMeasure;

interface Summable
{
  /**
   * The sum between two `AngularMeasure`s. The resulting angle can be positive or negative.
   */
  public function sum(AngularMeasure $addend): static;

  /**
   * The sum between two `AngularMeasure`s. The resulting angle can only be positive.
   */
  public function absSum(AngularMeasure $addend): static;
}