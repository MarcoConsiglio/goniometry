# Changelog
## Unreleased - 2025-11-03
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