# Changelog

All Notable changes to `sebastiaanluca/laravel-boolean-dates` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## 9.0.0 (2025-02-07)

### Added

- Added support for PHP 8.4
- Added support for Laravel 12

### Changed

- Require minimum version of Laravel 11.32 to fix deprecation warnings. See https://github.com/laravel/framework/pull/50922.

### Removed

- Dropped support for PHP 8.2
- Dropped support for Laravel 10

## 8.0.0 (2024-02-25)

### Added

- Added support for PHP 8.3
- Added support for Laravel 11

### Removed

- Dropped support for PHP 8.1

## 7.0.1 (2023-02-06)

## 7.0.0 (2023-02-06)

### Added

- Added support for PHP 8.2
- Added support for Laravel 10

### Removed

- Dropped support for PHP 8.0
- Dropped support for Laravel 9

## 6.0.1 (2022-03-17)

### Fixed

- Fixed attribute getter value type hint

## 6.0.0 (2022-03-13)

⚠️ This release is a complete rewrite and changes the way it has to be used. Please consult the [README](README.md) for instructions.

### Added

- Added support for Laravel 9

### Changed

- Switched to using `\Illuminate\Support\Carbon` and `\Carbon\CarbonImmutable` instead of `\Carbon\Carbon`
- Cleaned up code internally
- Added `BooleanDateAttribute`

### Removed

- Dropped support for PHP 7.x
- Dropped support for Laravel 7 and 8
- Removed requirements for `nesbot/carbon`
- Removed `HasBooleanDates` trait

## 5.0.0 (2020-10-19)

### Added

- Added support for Laravel 8

## 4.0.0 (2020-04-24)

### Added

- Added support for Laravel 7

### Removed

- Dropped support for Laravel 5
- Dropped support for Laravel 6
- Dropped support for PHP 7.2

## 3.0.0 (2019-09-06)

### Added

- Added support for Laravel 6.0

## 2.0.2 (2019-03-08)

### Changed

- Replaced custom array subset with package

## 2.0.1 (2019-02-27)

### Fixed

- Correctly tag Laravel version requirement

## 2.0.0 (2019-02-27)

### Added

- Automatically detect a model's boolean date fields

### Changed

- Add support for Laravel 5.8 (requires PHP 7.2 or higher)
- Renamed `BooleanDates` trait to `HasBooleanDates`

### Removed

- Dropped support for Laravel 5.7 and lower

## 1.1.1 (2018-09-04)

### Fixed

- Allow using `nesbot/carbon` ^2.0 and up

## 1.1.0 (2018-09-04)

### Added

- Run tests against Laravel 5.7

## 1.0.4 (2018-08-26)

### Changed

- Updated readme (yes, again 🤓)

## 1.0.3 (2018-08-26)

### Changed

- Updated readme

## 1.0.2 (2018-08-26)

### Added

- Added example to readme intro

### Changed

- Changed Composer description

## 1.0.1 (2018-08-20)

### Fixed

- Require nesbot/carbon v1.22.1 to fix "Cannot access property xxxx::$lastErrors" (see https://github.com/briannesbitt/Carbon/issues/852)

## 1.0.0 (2018-08-19)

### Fixed

- Removed `$booleanDates` trait variable to resolve conflict with the model it's used in
- Always return a valid array when retrieving all boolean dates
- Fixed issue where converting a model to an array didn't include the correct boolean field values

## 0.2.1 (2018-07-26)

### Fixed

- Remove `self` return type hint (conflicted when returning `null` during an Artisan command)

## 0.2.0 (2018-07-26)

### Changed

- Allow using mutators and other features for boolean dates

### Fixed

- Allow multiple traits with the same methods (e.g. `getAttribute`)

## 0.1.1 (2018-07-26)

### Fixed

- Fixed service provider auto-discovery

## 0.1.0 (2018-07-26)

### Added

- Added BooleanDates model trait
