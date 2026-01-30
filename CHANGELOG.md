# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [4.0.0] - Unreleased

### Changed
- Updated to work with OXID eShop 7.5.x
- Minimum PHP version is now 8.3, tested up to PHP 8.5

## [3.0.0] - 2025-11-06

### Added
- `TitleFilter` and `ActiveFilter` for separating functionality of `ComponentFilters`

### Changed
- `ComponentFilters` is now in `Filter` subnamespace of `Datatype` namespace
- Update to work with OXID eShop 7.4.x

## [2.1.1] - 2025-07-30

### Fixed
- Use `deptrac/deptrac` as new deptrac composer package. The configuration was adjusted.

## [2.1.0] - 2025-06-11
This is stable release for v2.1.0. No changes have been made since v2.1.0-rc.1.

## [2.1.0-rc.1] - 2025-04-28

### Added
- New `parentTheme` and `parentVersions` fields in the `ThemeDataType`
- PHP 8.4 support

## [2.0.0] - 2025-04-25

### Changed
- Move ModuleDataType generation to Infrastructure
- Move ThemeDataType generation to Infrastructure

### Removed
- `OxidEsales\GraphQL\ConfigurationAccess\Shared\Subscriber\BeforeModuleDeactivation` because de/activation is already handled by shop

## [1.2.0] - 2024-11-27
This is the stable release of v1.2.0. No changes have been made since v1.2.0-rc.1.

## [1.2.0-rc.1] - 2024-11-06

### Added
- Theme list and filtering option on basis of theme name and status
- Module list and filtering option on basis of module name and status
- Activation of given theme by themeId
- Mutations to de/activate a module.
- Prevention of de/activation of certain modules mentioned in modules_blocklist.yaml.

## [1.1.0] - 2024-07-05
This is stable release for v1.1.0. No changes have been made since v1.1.0-rc.1.

## [1.1.0-rc.1] - 2024-05-30
### Added
- PHP 8.2 support
- Module activation dependency on GraphQL Base module

### Changed
- PHPUnit upgraded to version 10.x
- Codeception tests structure updated to Codeception 5

### Removed
- PHP 8.0 support

## [1.0.0] - 2024-02-07

- Initial release

[3.0.0]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v2.1.1...v3.0.0
[2.1.1]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v2.1.0...v2.1.1
[2.1.0]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v2.1.0-rc.1...v2.1.0
[2.1.0-rc.1]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v2.0.0...v2.1.0-rc.1
[2.0.0]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v1.2.0...v2.0.0
[1.2.0]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v1.2.0-rc.1...v1.2.0
[1.2.0-rc.1]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v1.1.0...v1.2.0-rc.1
[1.1.0]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v1.1.0-rc.1...v1.1.0
[1.1.0-rc.1]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v1.0.0...v1.1.0-rc.1
[1.0.0]: https://github.com/OXID-eSales/graphql-configuration-access/releases/tag/v1.0.0
