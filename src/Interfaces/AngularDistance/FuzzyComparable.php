<?php
namespace MarcoConsiglio\Goniometry\Interfaces\AngularDistance;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;

interface FuzzyComparable
{
  /**
   * Check if this `AngularDistance` is equal to `$beta` within an acceptable `$delta` 
   * error angle.
   */
  public function fuzzyEqual(AngularDistance $beta, Angle $delta): bool;

  /**
   * Alias for `fuzzyEqual()` method.
   */
  public function feq(AngularDistance $beta, Angle $delta): bool;
}