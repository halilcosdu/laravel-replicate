# Changelog

All notable changes to `laravel-replicate` will be documented in this file.

## v2.0.0 - 2026-07-11

### Added

- Laravel 13 and PHP 8.5 are now exercised by a resolvable Pest 4 / Testbench 11 toolchain.
- Replicate Files API support: `createFile`, `listFiles`, `getFile`, `deleteFile`, and `downloadFile`.
- `verifyWebhook()` validates Replicate's HMAC-SHA256 signatures, supports multiple `v1` signatures during key rotation, and rejects stale deliveries using a configurable replay tolerance.
- `createOfficialModelPrediction()` mirrors the official-model endpoint without the unused legacy version argument.
- Explicit `Response` return types and typed facade metadata across the public client API.

### Changed

- Supported framework range is now Laravel 11–13. Laravel 10 support was removed because it is end-of-life.
- CI covers Laravel 11–13 and PHP 8.2–8.5 using both lowest and stable dependency sets; PHP 8.5 is paired with Laravel 12 and 13 according to Laravel's official support matrix.
- Laravel 11 is explicitly documented as EOL legacy compatibility; only its isolated CI rows relax Composer's security blocker so the package can continue exercising that requested migration target.
- Development constraints now allow Pest 3/4, Pest Laravel Plugin 3/4, and Collision 8/9 so every declared Laravel version can actually resolve.
- Code coverage reports are generated only by the dedicated `composer test-coverage` command, avoiding false CI failures when no coverage driver is installed.
- README was rebuilt around installation, compatibility, production prediction flows, file uploads, webhook security, errors, and the current API surface.

### Deprecated

- `createModelPrediction($owner, $name, $version, $data, $headers)` remains backward compatible, but its version argument has always been ignored by Replicate's official-model endpoint. Use `createOfficialModelPrediction()` for new code.

### Fixed

- Added a typed internal HTTP facade so PHPStan and IDEs understand `Http::replicate()`; obsolete macro errors were removed from the baseline.
- Added direct `illuminate/http` and `illuminate/support` requirements for framework components used by the package.

## v1.3.0 - 2026-07-03

### Added
- **API parity — 6 previously-missing endpoints:**
  - `search($query, $limit = null)` — new `SearchService` (beta `GET /search`).
  - `updateModel($owner, $name, $data)` — `PATCH /models/{owner}/{name}`.
  - `searchModels($query)` — `QUERY /models` (non-standard HTTP method, raw `text/plain` body).
  - `listModelExamples($owner, $name, $query = [])` — `GET /models/{owner}/{name}/examples`.
  - `getModelReadme($owner, $name)` — `GET /models/{owner}/{name}/readme` (returns plain-text Markdown).
  - `deleteDeployment($owner, $name)` — `DELETE /deployments/{owner}/{name}`.
- **Prediction headers** — `createPrediction`, `createModelPrediction`, and `createDeploymentPrediction` now accept an optional `$headers` array, enabling sync mode (`Prefer: wait=n`) and auto-cancel (`Cancel-After: 5m`). Backwards compatible (defaults to no extra headers).
- **List filters / pagination** — every list method (`listPredictions`, `listModels`, `listDeployments`, `listCollections`, `listTrainings`, `listModelExamples`) now accepts an optional `$query` array forwarded as query parameters (`cursor`, `created_after`, `sort_by`, etc.). Backwards compatible.

### Tests
- Added `Http::fake` tests for every new method, including header forwarding (`Prefer`/`Cancel-After`), query-parameter forwarding, and the `QUERY`+`text/plain` body shape. Test count: 32 → 48.

## v1.2.1 - 2026-07-03

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
