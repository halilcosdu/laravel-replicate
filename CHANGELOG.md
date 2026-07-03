# Changelog

All notable changes to `laravel-replicate` will be documented in this file.

## Unreleased

### Added
- **Test coverage.** The package previously only asserted container/facade wiring. Added `Http::fake`-based tests for every service method (26 endpoints) plus the `Http::replicate()` macro (base URL, bearer token, JSON accept header, custom API URL). Test count: 2 → 32. `Http::preventStrayRequests()` is now enabled to keep the suite hermetic.

### Changed
- **CI matrix** now tests PHP 8.4 and actually tests Laravel 10.x (previously claimed but untested). Matrix: PHP 8.2/8.3/8.4 × Laravel 10/11/12/13, with `php 8.2 + Laravel 13` and `php 8.4 + Laravel 10` excluded.
- Bumped GitHub Actions: `actions/checkout` v4 → v6 (run-tests, phpstan, fix-php-code-style, update-changelog), `ramsey/composer-install` v3 → v4, `dependabot/fetch-metadata` v2.4.0 → v3.0.0. Supersedes dependabot #17, #21, #22.

### Fixed
- **PHPStan was broken** by an invalid `checkMissingIterableValueType` option in `phpstan.neon.dist` (removed in PHPStan 2.x). The option was removed and the existing `Http::replicate()` macro errors were captured into a fresh baseline so static analysis runs clean.

### Documentation
- README: documented the previously-undocumented `deleteModel()` method, and added an honest "Current limitations" section (pagination/filters, `Prefer`/`Cancel-After` headers, and the 6 not-yet-implemented endpoints), replacing the misleading "Reference:" line that implied full API parity.

## v1.2.0 - Laravel 13 Support - 2026-04-09

### What's Changed

* Added Laravel 13 support to composer.json dependencies
* Updated GitHub Actions CI workflow to test against Laravel 13.x with Orchestra Testbench 11.x
* Package now supports Laravel 10.x, 11.x, 12.x, and 13.x
* Closes #23

## v1.0.2 - 2024-04-27

**Full Changelog**: https://github.com/halilcosdu/laravel-replicate/compare/v1.0.0...v1.0.2

## v1.0.0 - 2024-04-27

### What's Changed

* Bump dependabot/fetch-metadata from 1.6.0 to 2.1.0 by @dependabot in https://github.com/halilcosdu/laravel-replicate/pull/1

### New Contributors

* @dependabot made their first contribution in https://github.com/halilcosdu/laravel-replicate/pull/1

**Full Changelog**: https://github.com/halilcosdu/laravel-replicate/commits/v1.0.0
