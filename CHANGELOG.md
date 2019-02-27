# Changelog

All Notable changes to `sebastiaanluca/laravel-boolean-dates` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

##  Unreleased

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

##  1.0.4 (2018-08-26)

### Changed

- Updated readme (yes, again 🤓)

##  1.0.3 (2018-08-26)

### Changed

- Updated readme

##  1.0.2 (2018-08-26)

### Added

- Added example to readme intro

### Changed

- Changed Composer description

##  1.0.1 (2018-08-20)

### Fixed

- Require nesbot/carbon v1.22.1 to fix "Cannot access property xxxx::$lastErrors" (see https://github.com/briannesbitt/Carbon/issues/852)

##  1.0.0 (2018-08-19)

### Fixed

- Removed `$booleanDates` trait variable to resolve conflict with the model it's used in
- Always return a valid array when retrieving all boolean dates
- Fixed issue where converting a model to an array didn't include the correct boolean field values

##  0.2.1 (2018-07-26)

### Fixed

- Remove `self` return type hint (conflicted when returning `null` during an Artisan command)

##  0.2.0 (2018-07-26)

### Changed

- Allow using mutators and other features for boolean dates

### Fixed

- Allow multiple traits with the same methods (e.g. `getAttribute`)

##  0.1.1 (2018-07-26)

### Fixed

- Fixed service provider auto-discovery

##  0.1.0 (2018-07-26)

### Added

- Added BooleanDates model trait
