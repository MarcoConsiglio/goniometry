<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Strategy;

abstract class ComparisonStrategy implements Strategy
{
    public function __construct(protected Angle $alfa) {}
}