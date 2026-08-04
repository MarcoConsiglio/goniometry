<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

/**
 * How an `Angle` should be constructed.
 * 
 * @internal
 */
interface AngularMeasureBuilder
{
    /**
     * Fetch the data that will be used to build an `Angle`.
     */
    public function fetchData(): array;
}