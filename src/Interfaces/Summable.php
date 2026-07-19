<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

use MarcoConsiglio\Goniometry\AngularMeasure;

interface Summable
{
  /**
   * The sum between two `Angle`s. The resulting angle can be positive or negative.
   */
  public function sum(Summable&AngularMeasure $addend): static;

  /**
   * The sum between two `Angle`s. The resulting angle can only be positive.
   */
  public function absSum(Summable&AngularMeasure $addend): static;
}