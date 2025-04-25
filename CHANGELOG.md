# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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

[2.0.0]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v1.2.0...v2.0.0
[1.2.0]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v1.2.0-rc.1...v1.2.0
[1.2.0-rc.1]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v1.1.0...v1.2.0-rc.1
[1.1.0]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v1.1.0-rc.1...v1.1.0
[1.1.0-rc.1]: https://github.com/OXID-eSales/graphql-configuration-access/compare/v1.0.0...v1.1.0-rc.1
[1.0.0]: https://github.com/OXID-eSales/graphql-configuration-access/releases/tag/v1.0.0
