# goniometry
![GitHub License](https://img.shields.io/github/license/marcoconsiglio/goniometry)
![GitHub Release](https://img.shields.io/github/v/release/marcoconsiglio/goniometry)
![Static Badge](https://img.shields.io/badge/version-v2.0.1-white)

![Static Badge](https://img.shields.io/badge/Line%20coverage-100%25-rgb(40%2C167%2C69)?labelColor=%23fff&color=rgb(40%2C167%2C69))
![Static Badge](https://img.shields.io/badge/Branch%20coverage-99%25-rgb(40%2C167%2C69)?labelColor=%23fff&color=rgb(40%2C167%2C69))
![Static Badge](https://img.shields.io/badge/Path%20coverage-96%25-rgb(40%2C167%2C69)?labelColor=%23fff&color=rgb(40%2C167%2C69))



A PHP support for string, decimal, radian and object angles, providing goniometric algebra and comparison between angles.
# Index
- [Index](#index)
- [Requirements](#requirements)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Usage](#usage)
  - [Creating an angle](#creating-an-angle)
    - [Degrees, minutes and seconds](#degrees-minutes-and-seconds)
    - [String](#string)
    - [Decimal (float)](#decimal-float)
    - [Radian (float)](#radian-float)
  - [Getting angle values](#getting-angle-values)
    - [Casting](#casting)
      - [To decimal (float)](#to-decimal-float)
      - [To radian (float)](#to-radian-float)
      - [To string](#to-string)
  - [Direction](#direction)
  - [Comparison](#comparison)
    - [$\alpha \gt \beta$ (greater than)](#greater-than)
    - [$\alpha \ge \beta$ (greater than or equal)](#greater-than-or-equal)
    - [$\alpha \lt \beta$ (less than)](#less-than)
    - [$\alpha \le \beta$ (less than or equal)](#less-than-or-equal)
    - [$\alpha \cong \beta$ (equal)](#equal)
    - [$\alpha \ncong \beta$ (different)](#different)
  - [Algebraic sum between two angles](#algebraic-sum-between-two-angles)
- [API documentation](#api-documentation)

# Requirements
- PHP v8.4+
# Installation
`composer require marcoconsiglio/goniometry`
# Quick Start
Import this class to represent angles.
```php
use MarcoConsiglio\Goniometry\Angle;
```
Import this class to sum angles.
```php
use MarcoConsiglio\Goniometry\Operations\Sum;
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
### Degrees, minutes and seconds
This creates an angle from its values in degrees, minutes and seconds:
```php
$alfa = Angle::createFromValues(180, 12, 43, Angle::CLOCKWISE); // 180° 12' 43"
```
`Angle::COUNTERCLOCKWISE` is the plus sign, `Angle::CLOCKWISE` is the minus sign.

The `AngleOverflowException` is thrown when you try to create an angle:
- with more than $\pm360^\circ$
- with more than $59'$
- with more than $59.\overline{9}''$.
### String
This creates an angle from its textual representation:
```php
$beta = Angle::createFromString("180° 12' 43\""); // Input from the user
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

### Decimal (float)
This create an angle from its decimal representation:
```php
$gamma = Angle::createFromDecimal(180.2119); // 180.2119°
```

The `AngleOverflowException` is thrown when you try to create an `Angle` with more than $\pm360.0^{\circ}$.

### Radian (float)
This create an angle from its radian representation:
```php
$delta = Angle::createFromRadian(M_PI); // deg2rad(M_PI) = 180°
```
The `AngleOverflowException` is thrown when you try to create an `Angle` with more than $\pm2\pi$.

## Getting angle values
You can obtain degrees values separated in an array (simple by default, or associative):
```php
$values = $alfa->getDegrees();
echo $values[0]; // Degrees
echo $values[1]; // Minutes
echo $values[2]; // Seconds
$values = $alfa->getDegrees(true);
echo $value['degrees'];
echo $value['minutes'];
echo $value['seconds'];
```
There is read-only properties too:
```php
$alfa->degrees;   // 180
$alfa->minutes;   // 12
$alfa->seconds;   // 43
$alfa->direction; // Angle::CLOCKWISE (1)
```
### Casting
When the precision parameter is needed, you can obtain your maximum available precision with
the `PHP_FLOAT_DIG` constant.

#### To decimal (float)
You can cast the angle to decimal, with optional precision:
```php
$alfa->toDecimal(); // 180.2
$alfa->toDecimal(4); // 180.2119
$alfa->toDecimal(PHP_FLOAT_DIG) // 180.211971543295645
```
If the number of decimal places is not set, the casting operation preserve the original precision at the time the angle was built.

You can obtain a suggested precision to correctly represent the sexadecimal value of the `Angle` instance.
```php
$precision = $alfa->suggested_decimal_precision;
$alfa->toDecimal($precision);
```
#### To radian (float)
You can cast the angle to radian, with optional precision:
```php
$alfa->toRadian(); // 3.1
$alfa->toRadian(3); // 3.141
$alfa->toRadian(PHP_FLOAT_DIG); // 3.141592653589793 
```
If the number of decimal places is not set, the casting operation preserve the original precision at the time the angle was built.

You can obtain the original precision to correctly represent the radian value of the `Angle` instance.
```php
$precision = $alfa->original_radian_precision;
$alfa->toRadian($precision);
```

#### To string
You can cast the angle to a string representation:
```php
(string) $alfa; // 180° 30' 25.7"
```
In this case, maximum precision of seconds will be `PHP_FLOAT_DIG`.

## Direction
Positive angles are represented by the class constant
```php
Angle::COUNTER_CLOCKWISE; // 1
```
while negative angles are represented by the opposite class constant:
```php
Angle::CLOCKWISE; // -1
```
You can toggle direction:
```php
$beta = $alfa->toggleDirection();
```
Since the `Angle` instance is immutable, the `toggleDirection()` method returns a copy with the opposite sign.

You can check if an angle is clockwise or counterclockwise.
```php
// If $alfa is a positive angle
$alfa->isCounterClockwise();    // true
$alfa->isClockwise();           // false
$beta->isCounterClockwise();    // false
$beta->isClockwise();           // true
```

## Comparison
You can compare an angle with a numeric value (not radian but decimal), numeric string or another `Angle` object.
Comparisons are performed with absolute values (congruent comparison), meaning that $-90^\circ\cong+90^\circ$.

If you need a relative comparison, you should cast the angle to decimal and then perform the arithmetic comparison,
meaning that $-90.0^\circ\lt+90.0^\circ$.

Each comparison can be performed using 
- a string angle, 
- an integer (sexagesimal degrees), 
- a decimal (sexadecimal degrees), 
- or another instance of `Angle`. 

Comparisons via radian values ​​are not available.

You can specify an optional precision expressed as the number of decimal places used to round the angle value. The precision is only used when comparing to an integer, decimal (degrees), or another `Angle` object.

```php
$alfa = Angle::createFromDecimal(179.999);
$alfa->isEqual(90, 0);  // true
$alfa->isEqual(90, 3);  // false
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
$alfa->isGreaterThanOrEqual(90);        // true 180 ≧  90
$alfa->gte("180 0' 0\"");               // true 180 ≧ 180
$beta->isGreaterThanOrEqual($gamma);    // true  90 ≧  90
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
$alfa->isLessThanOrEqual(180);      // true 90 ≦ 180
$alfa->lte(90);                     // true 90 ≦ 90
$alfa->isLessThanOrEqual($beta);    // false 90 ≦ 180
$alfa->lte($beta);                  // false 90 ≦ 180
```
### $\alpha \cong \beta$ (equal) <a name="equal"></a>
```php
$alfa = Angle::createFromDecimal(180);
$beta = Angle::createFromDecimal(180);
$gamma = Angle::createFromDecimal(-180);
$alfa->isEqual($beta);  // true 180 ≅ 180
$alfa->eq($gamma);      // true 180 ≅ -180
```
### $\alpha \ncong \beta$ (different) <a name="different"></a>
```php
$alfa = Angle::createFromDecimal(90);
$beta = Angle::createFromDecimal(180);
$alfa->isDifferent(180);            // true   90 ≇ 180
$alfa->not(180);                    // true   90 ≇ 180
$alfa->isDifferent(-90);            // false  90 ≇ -90
$beta->not($alfa);                  // true   180 ≇ 90
```

## Algebraic sum between two angles
You can sum two angles

### Relative sum
```php
$alfa = Angle::createFromDecimal(180);
$beta = Angle::createFromDecimal(270);
$gamma = Angle::sum($alfa, $beta); // 180° + 270°
(string) $gamma; // 90° 0' 0"
```
Note that if the sum is less than $-360^\circ$ or more than $+360^\circ$, the resulting angle will be corrected to remain between these limits.

### Absolute sum
```php
$alfa = Angle::createFromDecimal(180);
$beta = Angle::createFromDecimal(-270);
$gamma = Angle::absSum($alfa, $beta); // 180° + abs(-270°)
(string) $gamma; // 90° 0' 0"
```
Note that if the sum is less than $0^\circ$ or more than $+360^\circ$, the resulting angle will be corrected to remain between these limits.

# API documentation
You can read the code documentation in `./docs/html/index.html`.