# Changelog

All notable changes to `boost-for-kiro-ide` will be documented in this file.

## [2.3.4] - 2026-06-09

### Fixed

- Added explicit `laravel/mcp: ~0.7.0` dependency to prevent installation errors when a project resolves an older `laravel/mcp` version (e.g. `^0.5.x` or `^0.6.x`) that has a different `ServerContext` constructor signature, causing `Unknown named parameter $serverName`.

## [2.3.3] - 2026-05-20

### Changed

- Updated `laravel/boost` dependency to `v2.4.8`.
- Verified compatibility of the prompt-to-hook converter with the latest Laravel Boost version.

### Added

- Added `HookInstallerTest` integration test to ensure prompt discovery, rendering, and hook conversion work as expected.

## [2.3.2] - 2026-05-07

### Fixed

- Fixed an issue (#8) where prompt names containing slashes (e.g., `filament/model`) would cause a "Failed to open stream" error by properly sanitizing the generated `.kiro.hook` filenames.

## [2.3.1] - 2026-04-21

### Changed

- Streamlined `README.md` by removing redundant sections already covered by the official Laravel Boost documentation.
- Removed obsolete manual testing guide (`MANUAL_TESTING_GUIDE.md`) that covered features now natively handled by Laravel Boost v2.4+.
- Added proper attribution to community contributor Karel Faille (@shaffe-fr) for PR #7.

## [2.3.0] - 2026-04-21

### Changed

- **BREAKING**: Updated `laravel/boost` base dependency to `^2.4`.
- **BREAKING**: Removed native Kiro CodeEnvironment registration, as Boost 2.4+ natively supports Kiro IDE and registers Kiro agents and MCP servers out-of-the-box.
- Migrated default guidelines orientation to `AGENTS.md` (now handled natively by Laravel Boost).
- Rewrote the package's focus strictly as a "Prompt-to-Hook" converter extension for the Kiro IDE.
- Officially added Laravel 13.x compatibility testing and support.

## [2.2.0] - 2026-04-19

### Added

- Added Prompt-to-Hook conversion: Boost MCP prompts are now automatically converted into Kiro Agent Hooks.
- Added `boost:kiro-hooks` command to manually sync hooks.

### Changed

- **Un-deprecated:** This package is no longer abandoned! It now provides essential Kiro-specific hook syncing that is not natively available in `laravel/boost`.

## [2.1.0] - 2026-04-19

### Changed

- Updated `orchestra/testbench` dependency to `^9.15.0|^10.6|^11.0` to test against Laravel 13 features locally
- Updated `pestphp/pest` dependency to `^3.8.4|^4.0` for Laravel 13 compatibility
- Fixed `BoostForKiroServiceProvider` throwing `InvalidArgumentException` on newer `laravel/boost` versions that natively include Kiro
- Updated tests to dynamically resolve agent class names natively from boost or from local namespace

### Deprecated

- This package is now **abandoned**. `laravel/boost` (v2.4+) natively ships with Kiro IDE support, rendering this extension redundant.

## [2.0.4] - 2026-03-03

### Added

- Made `guidelinesPath()` configurable via `boost.agents.kiro.guidelines_path` config key
- Added "Custom Guidelines Path" section to README documenting the new configuration option

### Changed

- Default guidelines path remains `.kiro/steering/laravel-boost.md` (Kiro's native steering convention)
- Teams using multiple AI IDEs can now opt in to `AGENTS.md` or any custom path via configuration

### Credits

- Thanks to [@FSElias](https://github.com/FSElias) for the initial implementation in [#6](https://github.com/jotafurtado/boost-for-kiro-ide/pull/6)

## [2.0.3] - 2026-02-07

### Changed

- **BREAKING**: Bumped minimum PHP version from `^8.1` to `^8.2` (required by `laravel/boost ^2.0`)
- **BREAKING**: Dropped Laravel 10 support (Testbench `^8.x` removed, now `^9.15|^10.6`)
- **BREAKING**: Dropped Pest 2.x support (now `^3.8.4` only)
- Updated to Laravel Boost v2.1.1 API: `Kiro` now extends `Agent` (was `CodeEnvironment`) and implements `SupportsGuidelines`, `SupportsMcp`, `SupportsSkills` (was `Agent`, `McpClient`)
- ServiceProvider now uses `Boost::registerAgent()` instead of legacy `Boost::registerCodeEnvironment()`
- ServiceProvider follows the documented pattern: empty `register()`, registration via Facade in `boot()`
- Aligned `Kiro` class with `ClaudeCode.php` reference implementation

### Added

- Added `skillsPath()` method returning `'.kiro/skills'` (implements `SupportsSkills` contract)
- Added explicit `mcpInstallationStrategy()` method returning `McpInstallationStrategy::FILE`

### Fixed

- Fixed ServiceProvider to use `Boost::registerAgent()` in `boot()` instead of legacy `$this->app->booted()` + manual `BoostManager` resolution in `register()` — root cause of Kiro not appearing in `boost:install`
- Changed `mcpConfigPath()` return type from `?string` to `string` to match reference implementations

### Removed

- Removed legacy `$this->app->booted()` callback, manual `BoostManager` resolution, try/catch block, and `BoostManager` import from ServiceProvider
- Removed verbose docblocks from `Kiro` class
- Removed redundant integration test files
- Dropped PHP 8.1 and Laravel 10 from CI test matrix

## [2.0.2] - 2026-02-07

### Fixed

- Fixed Kiro not appearing in `boost:install` command agent selection
- Changed ServiceProvider registration to use `register()` method with `booted()` callback
- Ensures Kiro is registered before boost:install command runs

## [2.0.1] - 2026-02-07

### Removed

- Removed `docs/` folder - unnecessary for a complementary package
- Removed `.kiro/` folder from repository and added to `.gitignore`

### Changed

- Cleaned up repository structure to focus on core functionality

## [2.0.0] - 2026-02-02

### Changed

- **BREAKING**: Updated to support Laravel Boost 1.8.2+ with new CodeEnvironment API
- Changed from standalone interfaces to `CodeEnvironment` base class with `Agent` and `McpClient` contracts
- Updated `mcpConfigPath()` return type from `string` to `?string` to match new interface
- Improved ServiceProvider to handle cases where BoostManager is not available
- Updated all tests to use new `getCodeEnvironments()` method instead of deprecated `getAgents()`

### Fixed

- Fixed compatibility with Laravel Boost 1.8.x API changes
- Fixed ServiceProvider registration to work correctly when Boost is disabled or not configured
- Fixed error "Call to undefined method Laravel\Boost\BoostManager::registerCodeEnvironment()" in projects where Boost is not properly initialized

### Added

- Added support for Laravel Boost v2.0 Skills system (works automatically)
- Verified compatibility with all Laravel Boost v2.0 features

### Notes

- No code changes required - Skills system works automatically with Kiro IDE
- The package continues to implement the same interfaces (Agent, McpClient, CodeEnvironment)
- All existing functionality remains unchanged and fully compatible

### Migration

To upgrade to Laravel Boost v2.0:

1. Update your dependencies:

   ```bash
   composer update jotafurtado/boost-for-kiro-ide laravel/boost
   ```

2. Re-run the Boost installation to ensure all configurations are up to date:

   ```bash
   php artisan boost:install
   ```

3. (Optional) Install Skills using the new command:
   ```bash
   php artisan boost:add-skill owner/repo
   ```

For more information about the Skills system, see the [Laravel Boost documentation](https://github.com/laravel/boost).

## [1.0.6] - 2026-01-04

### Changed

- Updated `laravel/boost` dependency to v1.8.3.

## [1.0.5] - 2025-11-17

### Fixed

- Fixed fatal error during package installation when laravel/boost is not yet loaded
- Added class_exists check in ServiceProvider to prevent "Class Laravel\Boost\Boost not found" error
- Improved installation reliability for new users

## [1.0.4] - 2025-11-17

### Changed

- Updated all dependencies to their latest versions:
  - laravel/boost: ^1.0 (latest: 1.8.0)
  - laravel/pint: ^1.20 (latest: 1.25.1)
  - mockery/mockery: ^1.6.12 (latest: 1.6.12)
  - orchestra/testbench: ^8.36.0|^9.15.0|^10.6 (latest: 10.6.0)
  - pestphp/pest: ^2.36.0|^3.8.4 (latest: 3.8.4)
  - phpstan/phpstan: ^2.1 (latest: 2.1.32)

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
