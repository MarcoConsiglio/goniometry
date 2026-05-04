# Changelog
## Unreleased
## Added
- `AngularDistance` class implementing the `Angle` interface to represent angular distance between two objects.
- `SexadecimalAngularDistance` class to represent sexadecimal value of an `AngularDistance` object.
- `SexadecimalValue` interface to express the common behaviour of `SexadecimalDegrees` and `SexadecimalAngularDistance` classes.
- `SexadecimalValue::toggleDirection()` to return the opposite direction of a sexadecimal value.
- `WithAngleFaker::{`  
&ensp;&ensp;&ensp;&ensp;`positiveRandomAngularDistance()`  
&ensp;&ensp;&ensp;&ensp;`negativeRandomAngularDistance()`  
&ensp;&ensp;&ensp;&ensp;`randomAngularDistance()`  
`}` method to randomly generate `AngularDistance` objects.

## v4.1.1 2025-04-29
### Changed
- API documentation.
### Deprecated
- `RegExFailureException` class, use `NoMatchException` instead.

## v4.1.0 2025-04-22
### Added
- `Angle::fuzzyEqual` method to check if an `Angle` is almost equal to another one within an acceptable error.
- `Angle::absolute()` method to always return an `Angle` with `Direction::COUNTER_CLOCKWISE`.
### Changed
- API and README documentation.

## v4.0.1 2025-04-09
### Fixed
- [#15](https://github.com/MarcoConsiglio/goniometry/issues/15).

## v4.0.0 2025-04-08
### Added
- `Angle::toSexagesimalDegrees()` to return the `SexagesimalDegrees` values of an `Angle`.
### Changed
- `WithAngleFaker::{`  
&ensp;&ensp;&ensp;&ensp;`randomDegrees()`  
&ensp;&ensp;&ensp;&ensp;`randomMinutes()`  
&ensp;&ensp;&ensp;&ensp;`randomSeconds()`  
&ensp;&ensp;&ensp;&ensp;`randomAngle()`  
&ensp;&ensp;&ensp;&ensp;`positiveRandomAngle()`  
&ensp;&ensp;&ensp;&ensp;`negativeRandomAngle()`  
&ensp;&ensp;&ensp;&ensp;`randomSexagesimalString()`  
&ensp;&ensp;&ensp;&ensp;`randomSexagesimal()`  
&ensp;&ensp;&ensp;&ensp;`positiveRandomSexagesimal()`  
&ensp;&ensp;&ensp;&ensp;`negativeRandomSexagesimal()`  
&ensp;&ensp;&ensp;&ensp;`randomSexadecimal()`  
&ensp;&ensp;&ensp;&ensp;`positiveRandomSexadecimal()`  
&ensp;&ensp;&ensp;&ensp;`negativeRandomSexadecimal()`  
&ensp;&ensp;&ensp;&ensp;`randomRadian()`  
&ensp;&ensp;&ensp;&ensp;`positiveRandomRadian()`  
&ensp;&ensp;&ensp;&ensp;`negativeRandomRadian()`  
`}` methods default parameters.
- `WithAngleFaker::{`  
&ensp;&ensp;&ensp;&ensp;`randomDegrees()`  
&ensp;&ensp;&ensp;&ensp;`randomMinutes()`  
&ensp;&ensp;&ensp;&ensp;`randomSeconds()`  
&ensp;&ensp;&ensp;&ensp;`randomSexagesimal()`  
&ensp;&ensp;&ensp;&ensp;`positiveRandomSexagesimal()`  
&ensp;&ensp;&ensp;&ensp;`negativeRandomSexagesimal()`   
&ensp;&ensp;&ensp;&ensp;`randomRadian()`  
&ensp;&ensp;&ensp;&ensp;`positiveRandomRadian()`  
&ensp;&ensp;&ensp;&ensp;`negativeRandomRadian()`  
`}` return type.
- API and README documentation.
### Removed
- `WithAngleFaker::SSN` constant
### Fixed
- Incorrect absolute sum when both `Angle`s are negative.

## v3.1.0 2025-03-17
### Added
- `WithAngleFaker` trait to support FakerPHP in order to generate random angular values.
### Changed
- README and API documentation.

## v3.0.0 2025-03-17
### Added
- `Degrees`, `Minutes` and `Second` that extends `ModularNumber` class to represents sexagesimal values with arbitrary precision in modular arithmetic.
- `SexadecimalDegrees` class  to stores a sexadecimal value with arbitrary precision in modular arithmetic.
- `Radian` class to store a radian value with arbitrary precision in modular arithmetic.
- `Direction` enum to represents angle directions.
- `SexagesimalDegrees` class to stores `Degrees`, `Minutes`, `Seconds` and `Direction` type values.
### Changed
- `Angle` class constructor visibility from `public` to `protected`.
- Renamed `FromAnglesToAbsoluteSum` class to `AbsoluteSum`.
- Renamed `FromAnglesToRelativeSum` class to `RelativeSum`.
- Renamed `FromDecimal` class to `FromSexadecimal`. 
- Renamed `FromDegrees` class to `FromSexagesimal`.
- Renamed `Angle::toDecimal()` method to `toFloat()`.
- Renamed `Angle::isGreaterThanOrEqual()` method to `isGreaterThanOrEqualTo()`.
- Renamed `Angle::isLessThanOrEqual()` method to `isLessThanOrEqualTo()`.
- Renamed `Angle::isEqual()` method to `isEqualTo()`.
- Renamed `Angle::isDifferent()` method to `isDifferentThan()`.
- `FromRadian` class constructor now accept also a `Radian` type input parameter.
- `FromString::fetchData()` method now return an array with {`SexagesimalDegrees`, `null`, `null`}.
- `FromRadian::fetchData()` method now return an array with {`SexagesimalDegrees`, `SexadecimalDegrees`, `Radian`}.
- `SumBuilder` class constructor parameters are renamed from `$first_angle` to `$alfa` and from `$second_angle` to `$beta`.
- Replaced `Angle::CLOCKWISE` with `Direction::CLOCKWISE`.
- Replaced `Angle::COUNTER_CLOCKWISE` with `Direction::COUNTER_CLOCKWISE`.
- Replaced `Angle::MAX_DEGREES` with `Degrees::MAX`.
- Replaced `Angle::MAX_MINUTES` with `Minutes::MAX`.
- Replaced `Angle::MAX_SECONDS` with `Seconds::MAX`.
- Replaced `Angle::MAX_RADIAN` with `Radian::MAX`.
- API and README documentation.
### Removed
- `AngleOverflowException`.

## v2.0.1 2025-12-17
### Fixed
- `Angle::absSum()` not performing correctly the sum, because the two addends must not be absolute and can be relative, while only the result must be corrected to remain in the positive angle limits ($0^\circ$ / $360^\circ$).

## v2.0.0 2025-12-17
## Added
- `FromAnglesToAbsoluteSum::class` builder to perform absolute sum between two angles.
- `FromAnglesToRelativeSum::class` builder to perform relative sum between two angles.
- Constructor to class `SumBuilder::class`.
- `Angle::absSum()` method to perform absolute sum between to angles.
### Changed
- API documentation.
- README documentation.
### Removed
- `FromAngles::class`. Use instead one of these two classes:
  - `FromAnglesToAbsoluteSum::class` or `Angle::absSum()` method,
  - `FromAnglesToRelativeSum::class` or `Angle::sum()` method.
- `Sum::class`. Use `Angle::sum()` instead.

## v1.5.1 2025-12-05
### Changed
- README documentation.
### Fixed
- Decimal and radian precision when casting an `Angle` instance to decimal or radian.

## v1.5.0 2025-12-04
### Added
- Properties `Angle::{`  
&ensp;&ensp;&ensp;&ensp;`$original_seconds_precision,`  
&ensp;&ensp;&ensp;&ensp;`$original_radian_precision`  
&ensp;&ensp;&ensp;&ensp;`$suggested_decimal_precision`  
`}` to cast the angle without specifing the precision.
### Changed
- Improvement of computational precision in `Angle::{`  
&ensp;&ensp;&ensp;&ensp;`toDecimal()`,  
&ensp;&ensp;&ensp;&ensp;`toRadian()`,  
`}` methods.
- Every concrete methods of `AngleBuilder::fetchData()` returns an array with the following values in order:
  - degrees,
  - minutes,
  - seconds,
  - direction,
  - suggested decimal precision,
  - original decimal value,
  - seconds value precision,
  - original radian value,
  - suggested radian precision
- `Angle::toggleDirection()` now returns a new instance making the Angle instance totally immutable.
### Removed
- Parameter $precision of the `Angle::toTotalSeconds()` method. Rounding of this value should be performed at user discretion.

## v1.4.1 2025-11-15
### Changed
- README documentation.

## v1.4.0 2025-11-11
### Added
- Support for assertion `assertObjectEquals()` method in PHPUnit through the method `Angle::equals()` which is an alias for `Angle::isEquals()`
## v1.3.0 2025-11-04
### Added
- `Angle::countDecimalPlaces()` public static method, useful to cound decimal places of a `float` variable.
### Changed
- Methods `Angle::toDecimal()`, `Angle::toRadian()`, `Angle::toTotalSeconds()` now accept `null` as precision, triggering the preservation of the original precision at the time the `Angle` was built.
- Updated API and README documentation.

## v1.2.0 2025-11-04
### Changed
- The `FromDecimal` builder now respect the correct precision for seconds value to built the Angle, based on the precision of the decimal number used to construct it.
- Updated API documentation.
### Added
- The static method `Angle::countDecimalPlaces()` calcs the number of decimal places of a decimal number.

## v1.1.2 - 2025-11-04
### Changed
- `Sum` operations are now performed with the maximum available precision.
- README documentation.

## v1.1.1 - 2025-11-03
### Fixed
- The `Angle::DEGREES_REGEX` regular expression matching 61° parsing the text "361°". Now, it excludes every values major than 360°.

## v1.1.0 - 2025-11-03
### Changed
- The regular expression for seconds: now the `Angle` class can be created from a string with any decimal place for the seconds part. 
- Creating an `Angle` from degrees value now accept seconds with more than one decimal place.
- Casting an `Angle` to string respects the original precision for seconds value instead the default display precision.
- API and README documentation.
### Added
- `Angle::$original_precision` property that stores the original number of decimal places for the seconds value.

## v1.0.1 - 2025-10-08
### Changed
- Visibility from public to protected of methods `checkOverflow`, `calcDegrees`, `calcMinutes`, `calcSeconds`, `calcSign` for all child classes of `AngleBuilder`, as they shouldn't use manually.
- License from Unlicense to MIT.

## v1.0.0 - 2025-10-08
### Added
- Angle class to represent angles, constructed from string, decimal (float), radian (float) or degrees, minutes and seconds inputs, both positive and negative.
- Casting to string, decimal (float), and radian (float).
- Comparison of two angles: equal, different, greater, greater or equal, less, less or equal.
- Algebraic sum between two angles.
- API documentation.