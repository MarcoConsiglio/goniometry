<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RelativeAngularDistance::class)]
class RelativeAngularDistanceTest extends FloatValidatorTestCase
{
    public function test_validate(): void
    {
        /**
         * $min ≤ -180
         * $max ≤ -180
         */
        // Arrange
        $this->setValidator();
        $this->setRange(-181, -181);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());
        
        /**
         * $min ≤ -180
         * $max in range
         */
        // Arrange
        $this->setValidator();
        $this->setRange(-181, -1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), -1);

        /**
         * $min in range
         * $max ≤ -180
         */
        // Arrange
        $this->setValidator();
        $this->setRange(-179, -181);

        // Act & Assert
        $this->testValidator(-179, $this->allowedMax());

        /**
         * $min ≥ +180
         * $max ≥ +180
         */
        // Arrange
        $this->setValidator();
        $this->setRange(+181, +181);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min in range
         * $max ≥ +180
         */
        // Arrange
        $this->setValidator();
        $this->setRange(+1, +181);

        // Act & Assert
        $this->testValidator(1, $this->allowedMax());


        /**
         * $min ≥ +180
         * $max in range
         */
        // Arrange
        $this->setValidator();
        $this->setRange(+181, +179);

        // Act & Assert
        $this->testValidator($this->allowedMin(), 179);
    }

    #[Override]
    protected function allowedMin(): float
    {
        return NextFloat::after(SexadecimalAngularDistance::MIN);
    }

    #[Override]
    protected function allowedMax(): float
    {
        return NextFloat::before(SexadecimalAngularDistance::MAX);
    }

    #[Override]
    protected function setValidator(): void
    {
        $this->validator = new RelativeAngularDistance;
    }
}