<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

interface CastableToRadian
{
  /**
   * Cast this `Angle` to its `float` radian representation.
   */
  public function toRadian(int $precision = PHP_FLOAT_DIG): float;
}