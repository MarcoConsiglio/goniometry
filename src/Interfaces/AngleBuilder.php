<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

/**
 * How an angle should be constructed.
 */
interface AngleBuilder
{
    /**
     * Fetch the data that will bee used for an angle.
     *
     * @return array
     */
    public function fetchData(): array;
}