<?php
namespace MarcoConsiglio\Goniometry\Tests;

use MarcoConsiglio\FakerPhpNumberHelpers\WithFakerHelpers;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Tests\Traits\WithFailureMessage;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use RoundingMode;

class TestCase extends PHPUnitTestCase
{
    use WithFailureMessage, WithFakerHelpers, WithAngleFaker;

    /**
     * A safe precision used when comparing `float` type variables.
     */
    protected const int PRECISION = PHP_FLOAT_DIG - 4;

    /**
     * This method is called before each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
    }

    /**
     * Convert a `$sexadecimal` value to sexagesimal values.
     * 
     * @return array{Degrees,Minutes,Seconds,Direction}
     */
    protected function toSexagesimal(float $sexadecimal): array
    {
        $direction = $sexadecimal >= 0 ? Direction::COUNTER_CLOCKWISE : Direction::CLOCKWISE;
        $sexadecimal = new SexadecimalDegrees(abs($sexadecimal));
        $degrees = new Degrees($sexadecimal->value->floor());
        $sexadecimal = new SexadecimalDegrees($sexadecimal->value->abs()->sub($degrees->value));
        $minutes = new Minutes($sexadecimal->value->mul(Minutes::MAX)->floor());
        $sexadecimal = new SexadecimalDegrees($sexadecimal->value->abs()->mul(Minutes::MAX)->sub($minutes->value));
        $seconds = new Seconds($sexadecimal->value->mul(Seconds::MAX));
        return [$degrees, $minutes, $seconds, $direction];
    }

    /**
     * Round a `float $value` in order to compare with another `float` safely.
     */
    public function safeRound(float $value): float
    {
        return round(
            $value, self::PRECISION, RoundingMode::HalfTowardsZero
        );
    }
}