# Changelog

All notable changes to `boost-for-kiro-ide` will be documented in this file.

## [Unreleased]

## [1.0.3] - 2025-11-10

### Fixed

- Fixed PHPStan configuration by removing invalid Laravel-specific parameters
- Fixed code formatting issues (line endings and blank lines)
- Fixed Pest test configuration by removing non-existent Feature test suite references
- Fixed test matrix to exclude PHP 8.1 from Laravel 11 tests (Laravel 11 requires PHP 8.2+)
- Added `/build/` directory to .gitignore

## [1.0.2] - 2025-11-10

### Fixed

- Fixed GitHub Actions workflows with proper dependency caching
- Improved error handling in CI/CD pipelines
- Fixed PHPStan configuration with proper memory limits and error format
- Added explicit Carbon dependency to avoid version conflicts

### Changed

- Updated actions/checkout from v5 to v4 for better stability
- Changed fail-fast to false in test matrix to see all test results
- Improved workflow performance with Composer cache

## [1.0.1] - 2025-11-10

### Changed

- Updated documentation (README.md and CONTRIBUTING.md) to English for wider community support
- Fixed GitHub repository URLs from `jcf` to `jotafurtado`
- Updated composer.json with correct GitHub repository links

### Removed

- Removed internal documentation files (PUBLISHING.md, PACKAGE_SUMMARY.md, QUICK_START.md)

## [1.0.0] - 2025-11-09

### Added

- First stable release
- Kiro CodeEnvironment implementation with Agent and McpClient interfaces
- Automatic detection of Kiro installations
- Seamless integration with Laravel Boost's installation process
