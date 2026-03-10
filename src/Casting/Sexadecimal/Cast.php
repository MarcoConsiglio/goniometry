<?php
namespace MarcoConsiglio\Goniometry\Casting\Sexadecimal;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;

class Cast implements ToSexadecimal
{
    /**
     * Construct the `Cast` object.
     */
    public function __construct(
        protected Degrees $degrees,
        protected Minutes $minutes,
        protected Seconds $seconds,
        protected Direction $direction,
        protected int|null $precision = null
    ) {}

    /**
     * Cast to float.
     */
    public function cast(): float
    {
        $decimal = $this->sexadecimal();
        if ($this->hasPrecisionBeenSet())
            return $decimal->toFloat($this->normalizePrecision($this->precision));
        return $decimal->toFloat($this->normalizePrecision($decimal->scale));
    }

    /**
     * Check if the precision has been set.
     */
    protected function hasPrecisionBeenSet(): bool
    {
        return $this->precision !== null;
    }

    /**
     * Calc the sexadecimal value.
     */
    protected function sexadecimal(): Number
    {
        return $this->degrees->value->plus(
                $this->minutes->value->div(Minutes::MAX)
            )->plus(
                $this->seconds->value->div(Minutes::MAX * Seconds::MAX)
            )->mul($this->direction->value);
    }

    /**
     * Normalize the precision to a suitable precision
     * when casting to float.
     */
    protected function normalizePrecision(int $precision): int
    {
        if ($precision < 0) $precision = abs($precision);
        if ($precision > PHP_FLOAT_DIG) $precision = PHP_FLOAT_DIG;
        return $precision;
    }
}