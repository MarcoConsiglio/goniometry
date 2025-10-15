# Changelog
## [1.0.1] - 2025-10-08
# Changed
- Visibility from public to protected of methods `checkOverflow`, `calcDegrees`, `calcMinutes`, `calcSeconds`, `calcSign` for all child classes of `AngleBuilder`, as they shouldn't use manually.

## [1.0.0] - 2025-10-08
### Added
- Angle class to represent angles, constructed from string, decimal (float), radian (float) or degrees, minutes and seconds inputs, both positive and negative.
- Casting to string, decimal (float), and radian (float).
- Comparison of two angles: equal, different, greater, greater or equal, less, less or equal.
- Algebraic sum between two angles.
- API documentation.