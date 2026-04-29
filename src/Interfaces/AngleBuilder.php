<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

/**
 * How an `Angle` should be constructed.
 */
interface AngleBuilder
{
    /**
     * Fetch the data that will be used to build an `Angle`.
     *
     * @return array
     */
    public function fetchData(): array;
}