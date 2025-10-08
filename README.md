# goniometry
<img alt="GitHub" src="https://img.shields.io/github/license/marcoconsiglio/goniometry">
<img alt="GitHub release (latest by date)" src="https://img.shields.io/github/v/release/marcoconsiglio/goniometry">
<img alt="Static Badge" src="https://img.shields.io/badge/Version-v0.0.0-white">
<br>
<img alt="Static Badge" src="https://img.shields.io/badge/Line_coverage-100.00%25-none?labelColor=%23ECECEC&color=rgb(40%2C%20167%2C%2069)">
<img alt="Static Badge" src="https://img.shields.io/badge/Branch_coverage-99.27%25-none?labelColor=%23ECECEC&color=rgb(40%2C%20167%2C%2069)">
<img alt="Static Badge" src="https://img.shields.io/badge/Path_coverage-79.82%25-none?labelColor=%23ECECEC&color=rgb(255%2C%20193%2C%207)">

A PHP support for string, decimal, radian and object angles, providing goniometric algebra and comparison between angles.
# Index
- [Index](#index)
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
    - [$\alpha > \beta$ (greater than)](#greater-than)
    - [$\alpha \ge \beta$ (greater than or equal)](#greater-than-or-equal)
    - [$\alpha < \beta$ (less than)](#less-than)
    - [$\alpha \le \beta$ (less than or equal)](#less-than-or-equal)
    - [$\alpha \cong \beta$ (equal)](#equal)
    - [$\alpha \ncong \beta$ (different)](#different)
  - [Algebric sum between two angles](#algebric-sum-between-two-angles)
- [API documentation](#api-documentation)
- [Testing](#testing)
  - [Code coverage](#code-coverage)

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
$alfa = new Angle(new FromDegrees(180, 12, 43, Angle::CLOCKWISE))
```
`Angle::COUNTERCLOCKWISE` is the plus sign, `Angle::CLOCKWISE` is the minus sign.

The `NoMatchException` is thrown when you try to create an angle:
- with more than $\pm360^\circ$
- with more than $59'$
- with more than $59.9''$.
- with a bad formatted string.
### String
This creates an angle from its textual representation:
```php
$beta = Angle::createFromString("180° 12' 43\""); // Input from the user
$beta = new Angle(new FromString("180° 12' 43\""));
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
- with more than $59.9''$.

### Decimal (float)
This create an angle from its decimal representation:
```php
$gamma = Angle::createFromDecimal(180.2119); // 180.2119°
$gamma = new Angle(new FromDecimal(180.2119));
```

The `AngleOverflowException` is thrown when you try to create an `Angle` with more than $\pm360.0^{\circ}$.

### Radian (float)
This create an angle from its radian representation:
```php
$delta = Angle::createFromRadian(M_PI); // deg2rad(M_PI) = 180°
$delta = new Angle(FromRadian(M_PI));
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
#### To decimal (float)
You can cast the angle to decimal, with optional precision:
```php
$alfa->toDecimal(); // 180.2
$alfa->toDecimal(4); // 180.2119
```
#### To radian (float)
You can cast the angle to radian, with optional precision:
```php
$alfa->toRadian(); // 3.1
$alfa->toRadian(3); // 3.145
```
#### To string
You can cast the angle to a string representation:
```php
(string) $alfa; // 180° 30' 25.7"
```
In this case, maximum precision of seconds will be ever one decimal digit.

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
$alfa->toggleDirection();
```
You can check if an angle is clockwise or counterclockwise.
```php
// If $alfa is a positive angle
$alfa->isClockwise();           // false
$alfa->isCounterClockwise();    // true
```

## Comparison
You can compare an angle with a numeric value, numeric string or another `Angle` object.
Comparisons are performed with absolute values (congruent comparison), meaning that $-90^\circ$ is equal to $+90^\circ$.
If you need a relative comparison, you should perform arithmetics instead. 
Warning! Comparisons are not available for radian values, you should perform arithmetics instead.

### $\alpha > \beta$ (greater than) <a name="greater-than"></a>
```php
$alfa = Angle::createFromDecimal(180);
$beta = Angle::createFromDecimal(90);
$gamma = Angle::createFromDecimal(360);
$alfa->isGreaterThan(90);       // true     180 >  90
$alfa->gt("90");                // true     180 >  90
$alfa->isGreaterThan($gamma);   // false    180 > 360
$alfa->gt($gamma);              // false    180 > 360
```

### $\alpha \ge \beta$ (greater than or equal) <a name="greater-than-or-equal"></a>
```php
$alfa = Angle::createFromDecimal(180);
$beta = Angle::createFromDecimal(90);
$gamma = Angle::createFromDecimal(90);
$alfa->isGreaterThanOrEqual(90);        // true 180 >=  90
$alfa->gte("180");                      // true 180 >= 180
$beta->isGreaterThanOrEqual($gamma);    // true  90 >=  90
$beta->gte(90);                         // true  90 >=  90
```

### $\alpha < \beta$ (less than) <a name="less-than"/></a>
```php
$alfa = Angle::createFromDecimal(90);
$beta = Angle::createFromDecimal(180);
$alfa->isLessThan(180);     // true  90 < 180
$alfa->lt(180);             // true  90 < 180
$alfa->isLessThan($beta);   // true  90 < 180
$beta->lt($alfa);           // true 180 < 90
```
### $\alpha \le \beta$ (less than or equal) <a name="less-than-or-equal"></a>
```php
$alfa = Angle::createFromDecimal(90);
$beta = Angle::createFromDecimal(180);
$alfa->isLessThanOrEqual(180);      // true
$alfa->lte(90);                     // true
$alfa->isLessThanOrEqual($beta);    // true
$alfa->lte($beta);                  // true
```
### $\alpha \cong \beta$ (equal) <a name="equal"></a>
```php
$alfa = Angle::createFromDecimal(180);
$beta = Angle::createFromDecimal(180);
$gamma = Angle::createFromDecimal(-180);
$alfa->isEqual($beta);  // true
$alfa->eq($gamma);      // true
```
### $\alpha \ncong \beta$ (different) <a name="different"></a>
```php
$alfa = Angle::createFromDecimal(90);
$beta = Angle::createFromDecimal(180);
$alfa->isDifferent(180);            // true
$alfa->not(180);                    // true
$alfa->isDifferent(-90);            // false
$beta->not($alfa);                  // true
```

## Algebric sum between two angles
The `Sum` class extends the `Angle` class, so you immediately obtain the algebric sum
between two angles, passing in its constructor a `FromAngles` builder, which is a `SumBuilder`.
```php
$alfa = Angle::createFromDecimal(180);
$beta = Angle::createFromDecimal(270);
$gamma = new Sum(new FromAngles($alfa, $beta));
(string) $gamma; // 90° 0' 0"
```
Note that if the sum is more than $\pm360^\circ$, the resulting angle will be corrected to remain between these limits.

# API documentation
You can read the code documentation in `./docs/index.html`.

To generate the API documentation use
```shell
vendor/bin/phpdoc run
```

# Testing
To perform tests use
```shell
vendor/bin/phpunit
```
At the end, it will produce a testbook both in text and html formats at `./testbook.txt` and `./testbook.html`.
## Code coverage
If you have Xdebug setup for code coverage, you can find an html report in `./tests/coverage_report/index.html`.