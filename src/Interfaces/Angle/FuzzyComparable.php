<?php
namespace MarcoConsiglio\Goniometry\Interfaces\Angle;

use MarcoConsiglio\Goniometry\Angle;

interface FuzzyComparable
{
  /**
   * Check if this `Angle` is equal to `$beta` within an acceptable `$delta` 
   * error angle.
   */
  public function fuzzyEqual(Angle $beta, Angle $delta): bool;

  /**
   * Alias for `fuzzyEqual()` method.
   */
  public function feq(Angle $beta, Angle $delta): bool;
}