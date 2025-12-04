# Changelog
## [1.5.0] 2025-12-04
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

## [1.4.1] 2025-11-15
### Changed
- README documentation.

## [1.4.0] 2025-11-11
### Added
- Support for assertion `assertObjectEquals()` method in PHPUnit through the method `Angle::equals()` which is an alias for `Angle::isEquals()`
## [1.3.0] 2025-11-04
### Added
- `Angle::countDecimalPlaces()` public static method, useful to cound decimal places of a `float` variable.
### Changed
- Methods `Angle::toDecimal()`, `Angle::toRadian()`, `Angle::toTotalSeconds()` now accept `null` as precision, triggering the preservation of the original precision at the time the `Angle` was built.
- Updated API and README documentation.

## [1.2.0] 2025-11-04
### Changed
- The `FromDecimal` builder now respect the correct precision for seconds value to built the Angle, based on the precision of the decimal number used to construct it.
- Updated API documentation.
### Added
- The static method `Angle::countDecimalPlaces()` calcs the number of decimal places of a decimal number.

## [1.1.2] - 2025-11-04
### Changed
- `Sum` operations are now performed with the maximum available precision.
- README documentation.

## [1.1.1] - 2025-11-03
### Fixed
- The `Angle::DEGREES_REGEX` regular expression matching 61° parsing the text "361°". Now, it excludes every values major than 360°.

## [1.1.0] - 2025-11-03
### Changed
- The regular expression for seconds: now the `Angle` class can be created from a string with any decimal place for the seconds part. 
- Creating an `Angle` from degrees value now accept seconds with more than one decimal place.
- Casting an `Angle` to string respects the original precision for seconds value instead the default display precision.
- API and README documentation.
### Added
- `Angle::$original_precision` property that stores the original number of decimal places for the seconds value.

## [1.0.1] - 2025-10-08
### Changed
- Visibility from public to protected of methods `checkOverflow`, `calcDegrees`, `calcMinutes`, `calcSeconds`, `calcSign` for all child classes of `AngleBuilder`, as they shouldn't use manually.
- License from Unlicense to MIT.

## [1.0.0] - 2025-10-08
### Added
- Angle class to represent angles, constructed from string, decimal (float), radian (float) or degrees, minutes and seconds inputs, both positive and negative.
- Casting to string, decimal (float), and radian (float).
- Comparison of two angles: equal, different, greater, greater or equal, less, less or equal.
- Algebraic sum between two angles.
- API documentation.