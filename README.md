# [goniometry](https://github.com/MarcoConsiglio/goniometry?tab=readme-ov-file#goniometry)
![GitHub License](https://img.shields.io/github/license/marcoconsiglio/goniometry)
![GitHub Release](https://img.shields.io/github/v/release/marcoconsiglio/goniometry)
![Static Badge](https://img.shields.io/badge/version-v4.1.1-white)

![Static Badge](https://img.shields.io/badge/Line%20coverage-100%25-rgb(40%2C167%2C69)?labelColor=%23fff&color=rgb(40%2C167%2C69))
![Static Badge](https://img.shields.io/badge/Branch%20coverage-100%25-rgb(40%2C167%2C69)?labelColor=%23fff&color=rgb(40%2C167%2C69))
![Static Badge](https://img.shields.io/badge/Path%20coverage-100%25-rgb(40%2C167%2C69)?labelColor=%23fff&color=rgb(40%2C167%2C69))

A PHP support for string, decimal, radian and object angles, providing goniometric algebra and comparison between angles.

# Index

- [Requirements](#requirements)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Usage](#usage)
  - [Creating an angle](#creating-an-angle)
    - [Sexagesimal (degrees, minutes, seconds)](#sexagesimal_values)
    - [Sexagesimal string](#sexadecimal_value)
    - [Sexadecimal float](#sexadecimal_value)
    - [Radian float](#radian_value)
  - [Getting angle values](#getting-angle-values)
    - [Casting](#casting)
      - [To sexadecimal (float)](#toFloat)
      - [To sexadecimal (object)](#toSexadecimalDegrees)
      - [To radian (float)](#toRadian)
      - [To string](#to-string)
  - [Direction](#direction)
  - [Comparison](#comparison)
    - [$\alpha \gt \beta$ (greater than)](#greater-than)
    - [$\alpha \ge \beta$ (greater than or equal)](#greater-than-or-equal)
    - [$\alpha \lt \beta$ (less than)](#less-than)
    - [$\alpha \le \beta$ (less than or equal)](#less-than-or-equal)
    - [$\alpha \cong \beta$ (equal)](#equal)
    - [$\alpha \ncong \beta$ (different)](#different)
  - [Fuzzy Comparison](#fuzzy-comparison)
    - [$\alpha~ \char"224A ~\beta$ (almost equal)](#almost-equal)
  - [Algebraic sum between two angles](#algebraic-sum-between-two-angles)
- [FakerPHP support](#fakerphp-support)
- [API documentation](#api-documentation)

# Requirements
- PHP v8.4+
- [BC Math](https://www.php.net/manual/en/book.bc.php) PHP extension
# Installation
`composer require marcoconsiglio/goniometry`
# Quick Start
Import this class to represent angles.
```php
use MarcoConsiglio\Goniometry\Angle;
```

Create an Angle object.
```php
$alfa = Angle::createFromValues(180, 30);
$beta = Angle::createFromString("180° 30'");
$gamma = Angle::createFromDecimal(180.5);
$delta = Angle::createFromRadian(M_PI); // 180°
```
# Usage
## Creating an angle
### Sexagesimal (`int` degrees, `int` minutes, `float` seconds) <a id="sexagesimal_values"></a>
This creates an angle from its values in degrees, minutes and seconds:
```php
$alfa = Angle::createFromValues(180, 12, 43.4618, Direction::CLOCKWISE); // -180° 12' 43.4618"
```
`Direction::COUNTER_CLOCKWISE` is the plus sign, `Direction::CLOCKWISE` is the minus sign.

A null angle (exactly $0^\circ\space0'\space0"$) will always have a `Direction::COUNTER_CLOCKWISE`.

### Sexagesimal (`string`)<a id="sexagesimal_string"></a>
This creates an angle from its textual representation:
```php
$beta = Angle::createFromString("-180° 12' 43.4618\"");
```

This is possible thanks to the regular expressions
```php
Angle::DEGREES_REGEX;
Angle::MINUTES_REGEX;
Angle::SECONDS_REGEX;
```
These regex expressions treat degrees and minutes as `int` type, but seconds are treated as a `float` type.

You can create a negative `Angle` if the string representation start with the minus (`-`) sign.

The `NoMatchException` is thrown when you try to create an angle:
- with more than $\pm360^\circ$
- with more than $59'$
- with more than $59.\overline{9}''$.

### Sexadecimal value (`float`)<a id="sexadecimal_value"></a>
This create an angle from its decimal representation:
```php
$gamma = Angle::createFromDecimal(180.2119);   //  180.2119°
$gamma = Angle::createFromDecimal(-180.2119);  // -180.2119°
$gamma = Angle::createFromDecimal(301.0);      //    1.0°
```

### Radian (`float`) <a id="radian_value"></a>
This create an angle from its radian representation:
```php
$delta = Angle::createFromRadian(M_PI);      //  π ≅  180°
$delta = Angle::createFromRadian(
  new Radian(Number::π())
);                                           //  π =  180°
$delta = Angle::createFromRadian(-M_PI);     // -π ≅ -180°
$delta = Angle::createFromRadian(2 * M_PI);  // 2π ≅    0°
```
If you need a precise π value, you can pass a `Radian` object constructed with the `Number::π()` static method that return the π constant with an arbitrary precision up to 54 digits.

The `Radian` class extend the `ModularNumber` class, whose API is documented in [marcoconsiglio/modular-arithmetic](https://github.com/MarcoConsiglio/php-modular-arithmetic).

For more info on `Number::π()` check the API of [marcoconsiglio/bcmath-extended](https://github.com/MarcoConsiglio/bcmath-extended).
## Getting angle values
You can obtain sexagesimal values separated in an array (simple by default, or associative):
```php
$values = $alfa->getDegrees();
echo $values[0]; // int
echo $values[1]; // int
echo $values[2]; // float
$values = $alfa->getDegrees(true);
echo $value['degrees']; // int
echo $value['minutes']; // int
echo $value['seconds']; // float
```
The angle's direction determines the sign of the degrees value.

There are read-only properties too:
```php
/** @var Degrees */
(string) $alfa->degrees;  // 180°
/** @var Minutes */
(string) $alfa->minutes;  // 12'
/** @var Seconds */
(string) $alfa->seconds;  // 43"
/** @var Direction */
$alfa->direction;         // Direction::CLOCKWISE (-1)
```
The `Degrees`, `Minutes`, and `Seconds` extends `ModularNumber`, whose API is documented in [marcoconsiglio/modular-arithmetic](https://github.com/MarcoConsiglio/php-modular-arithmetic).

You can cast `Degrees`, `Minutes`, and `Seconds` to `string`.

### Direction
Positive angles are represented by the enum constant
```php
Direction::COUNTER_CLOCKWISE; // 1
```
while negative angles are represented by the opposite enum constant:
```php
Direction::CLOCKWISE; // -1
```
You can toggle direction:
```php
$beta = $alfa->toggleDirection();
```
Since the `Angle` instance is immutable, the `toggleDirection()` method returns a copy with the opposite sign.

You can check if an `Angle` is clockwise or counterclockwise.
```php
// If $alfa is a positive angle
$alfa->isCounterClockwise();    // true
$alfa->isClockwise();           // false
// If $beta is a negative angle
$beta->isCounterClockwise();    // false
$beta->isClockwise();           // true
```

## Casting
### To `float` sexadecimal degrees <a id="toFloat"></a>
You can cast the angle to `float` type, with optional precision up to `PHP_FLOAT_DIG` decimal places:
```php
$alfa->toFloat();   // 180.211971543295645
$alfa->toFloat(4);  // 180.2119
$alfa->toFloat(200) // 180.211971543295645
```
You can specify a precision up to `PHP_FLOAT_DIG` decimal places.
If the number of decimal places is not set, `PHP_FLOAT_DIG` is used.

### To `SexadecimalDegrees` type <a id="toSexadecimalDegrees"></a>
If you need an arbitrary precision, you can obtain a `SexadecimalDegrees` instance representing the sexadecimal value of the angle.
```php
$sexadecimal = $alfa->toSexadecimalDegrees();
/** @var Number */
$sexadecimal->value;      // 180.2119715432956455962174521226543543
/** @var float */
$sexadecimal->value();    // 180.211971543295645
/** @var float */
$sexadecimal->value(3);   // 180.212
/** @var float */
$sexadecimal->value(12);  // 180.211971543296
```
The `$value` property is a `Number` object extending the `BCMath\Number` class, whose API is documented in [marcoconsiglio/bcmath-extended](https://github.com/MarcoConsiglio/bcmath-extended).

The `value()` method cast the `SexadecimalDegrees` object to `float`.
You can specify a precision up to `PHP_FLOAT_DIG` decimal places.
If the number of decimal places is not set, `PHP_FLOAT_DIG` is used.

### To `float` radian <a id="toRadian"></a>
You can cast the angle to radian (`float`), with optional precision up to `PHP_FLOAT_DIG` decimal places:
```php
$alfa->toRadian();    // 3.141592653589793
$alfa->toRadian(3);   // 3.141
$alfa->toRadian(200); // 3.141592653589793 
```
You can specify a precision up to `PHP_FLOAT_DIG` decimal places.
If the number of decimal places is not set, `PHP_FLOAT_DIG` is used.

### To `string` sexagesimal <a id="toString"></a>
You can cast the angle to a string representation:
```php
(string) $alfa; // 180° 30' 25.757385"
```
**WARNING!** In this case, maximum precision is _unknown_. The `Seconds` class uses the [BCMath extension](https://www.php.net/manual/en/book.bc.php) behind the scenes. The seconds value is stored with arbitrary precision, so in some cases the number of seconds could potentially have many digits, making the string very long.

## Comparison
You can compare an `Angle` object against a _sexadecimal_ or _sexagesimal_ value.

Comparisons are performed with absolute values (congruent comparison), meaning that $-90^\circ\cong+90^\circ$.

If you need a relative comparison, you should [cast the angle to a sexadecimal `float`](#toFloat) and then perform the arithmetic comparison,
meaning that $-90.0^\circ\lt+90.0^\circ$.

Each comparison can be performed against 
- a `string` angle (sexagesimal), 
- an `int` (sexagesimal degrees), 
- a `float` (sexadecimal degrees), 
- or another instance of `Angle`. 

Comparisons via radian values ​​are not available.

You can specify an optional precision expressed as the number of decimal places used to round the angle value. The precision is only used when comparing against a `float` (sexadecimal).

```php
$alfa = Angle::createFromDecimal(89.999);
$alfa->isEqualTo(90.0, 0);  // true with precision 0
$alfa->isEqualTo(90.0, 3);  // false with precision 3
```

### $\alpha > \beta$ (greater than) <a name="greater-than"></a>
```php
$alfa = Angle::createFromDecimal(180);
$beta = Angle::createFromDecimal(90);
$gamma = Angle::createFromDecimal(360);
$alfa->isGreaterThan(90);       // true     180 >  90
$alfa->gt("90° 0' 0\"");        // true     180 >  90
$alfa->isGreaterThan($gamma);   // false    180 > 360
$alfa->gt($gamma);              // false    180 > 360
```

### $\alpha ≧ \beta$ (greater than or equal) <a name="greater-than-or-equal"></a>
```php
$alfa = Angle::createFromDecimal(180);
$beta = Angle::createFromDecimal(90);
$gamma = Angle::createFromDecimal(90);
$alfa->isGreaterThanOrEqualTo(90);        // true 180 ≧  90
$alfa->gte("180 0' 0\"");               // true 180 ≧ 180
$beta->isGreaterThanOrEqualTo($alfa);    // true  90 ≧ 180
$beta->gte(90);                         // true  90 ≧  90
```

### $\alpha < \beta$ (less than) <a name="less-than"/></a>
```php
$alfa = Angle::createFromDecimal(90);
$beta = Angle::createFromDecimal(180);
$alfa->isLessThan(180);     // true  90 < 180
$alfa->lt(180);             // true  90 < 180
$alfa->isLessThan($beta);   // true  90 < 180
$beta->lt($alfa);           // false 180 < 90
```
### $\alpha ≦ \beta$ (less than or equal) <a name="less-than-or-equal"></a>
```php
$alfa = Angle::createFromDecimal(90);
$beta = Angle::createFromDecimal(180);
$alfa->isLessThanOrEqualTo(180);    // true 90 ≦ 180
$alfa->lte(90);                     // true 90 ≦ 90
$alfa->isLessThanOrEqualTo($beta);  // false 90 ≦ 180
$alfa->lte($beta);                  // false 90 ≦ 180
```
### $\alpha \cong \beta$ (equal) <a name="equal"></a>
```php
$alfa = Angle::createFromDecimal(180);
$beta = Angle::createFromDecimal(180);
$gamma = Angle::createFromDecimal(-180);
$alfa->isEqualTo($beta);  // true 180 ≅ 180
$alfa->eq($gamma);        // true 180 ≅ -180
```
### $\alpha \ncong \beta$ (different) <a name="different"></a>
```php
$alfa = Angle::createFromDecimal(90);
$beta = Angle::createFromDecimal(180);
$alfa->isDifferentThan(180);        // true   90 ≇ 180
$alfa->not(180);                    // true   90 ≇ 180
$alfa->isDifferentThan(-90);        // false  90 ≇ -90
$beta->not($alfa);                  // true   180 ≇ 90
```
## Fuzzy Comparison
When comparing two `Angle`s sometimes their difference is negligible. In this case you can use a fuzzy comparison specifine a delta error `Angle` within which the comparison will be succesful.

*Delta* (Δ) is the double of *epsilon* error (±ε).

### $\alpha~ \char"224A ~\beta$ (almost equal)
```php
$alfa = Angle::createFromDecimal(90.345);
$beta = Angle::createFromValue(90);
$delta = Angle::createFromValue(4); // ±2° error
$alfa->fuzzyEqual($beta, $delta); // true
$alfa->feq($beta, $delta); // true
```
## Algebraic sum between two angles
You can sum two angles

### Relative sum
The relative sum can return both positive or negative angle.
```php
$alfa = Angle::createFromDecimal(180);
$beta = Angle::createFromDecimal(-270);
$gamma = Angle::sum($alfa, $beta);  // 180° + (-270°) =
(string) $gamma;                    // -90° 0' 0"
```

### Absolute sum
The absolute sum will always return a positive angle.
```php
$alfa = Angle::createFromDecimal(180);
$beta = Angle::createFromDecimal(-270);
$gamma = Angle::absSum($alfa, $beta); // 180° + (-270°) =
(string) $gamma;                      // 270° 0' 0"
```
```php
$alfa = Angle::createFromDecimal(-180);
$beta = Angle::createFromDecimal(-270);
$gamma = Angle::absSum($alfa, $beta); // (-180°) + (-270°) =
(string) $gamma;                      // 270° 0' 0"
```
# FakerPHP support <a id="faker_php"></a>
This library provides support to [FakerPHP](https://fakerphp.org/) through the `WithAngleFaker` trait. Here's a list of the available methods.

| Method | Return type | Min (included) | Min (excluded) | Max (included) | Max (excluded) |
| --- | --- | --- | --- | --- | --- |
| `randomPrecision()` | `int` | 0 |  | `PHP_FLOAT_DIG` |  |
| `randomDegrees()` | `Degrees` | 0° |  | 359° |  |
| `randomMinutes()` | `Minutes` | 0' |  | 59' |  |
| `randomSeconds()` | `Seconds` | 0" |  |  | 60" |
| `randomAngle()` | `Angle` |  | -360° |  | +360° |
| `positiveRandomAngle()` | `Angle` | 0° |  |  | +360° |
| `negativeRandomAngle()` | `Angle` |  | -360° |  | 0° |
| `randomDirection()` | `Direction` | `CLOCKWISE` |  | `COUNTER_CLOCKWISE` |  |
| `randomSexagesimalString()` | `string` |  | -360° |  | +360° |
| `randomSexagesimal()` | `SexagesimalDegrees` |  | -360° |  | +360° |
| `positiveRandomSexagesimal()` | `SexagesimalDegrees` | 0° |  |  | +360° |
| `negativeRandomSexagesimal()` | `SexagesimalDegrees` |  | -360° |  | 0° |
| `randomSexadecimal()` | `float` |  | -360° |  | +360° |
| `positiveRandomSexadecimal()` | `float` | 0° |  |  | +360° |
| `negativeRandomSexadecimal()` | `float` |  | -360° |  | 0° |
| `randomRadian()` | `Radian` |  | -2π |  | +2π |
| `positiveRandomRadian()` | `Radian` | 0 |  |  | +2π |
| `negativeRandomRadian()` | `Radian` |  | -2π |  | 0 |

Check the [API documentation](#api-documentation) to find out more info about these methods.

# API documentation
You can read the code documentation in `./docs/html/index.html`.