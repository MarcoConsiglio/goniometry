<?php
namespace MarcoConsiglio\Goniometry\Builders\Traits;

/**
 * Specify the order in which to calculate the sexagesimal values.
 * 
 * @internal
 */
trait CalcOrderForSexagesimals
{
	/**
	 * Calc degrees, minutes seconds and sign in this order.
	 */
	protected function calcFromMostToLessSignificantValue(): void
	{
		$this->calcDegrees();
		$this->calcMinutes();
		$this->calcSeconds();
		$this->calcSign();
	}

	/**
	 * Calc seconds, minutes, degrees and sign in this order.
	 */
	protected function calcFromLessToMostSignificantValue(): void
	{
		$this->calcSeconds();
		$this->calcMinutes();
		$this->calcDegrees();
		$this->calcSign();
	}

    /**
     * Calc sexagesimal degrees.
     */
    abstract protected function calcDegrees(): void;

    /**
     * Calc sexagesimal minutes.
     */
    abstract protected function calcMinutes(): void;

    /**
     * Calc sexagesimal seconds.
     */
    abstract protected function calcSeconds(): void;

    /**
     * Calc the direction.
     */
    abstract protected function calcSign(): void;
}