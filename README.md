
[![Development](https://github.com/OXID-eSales/graphql-configuration-access/actions/workflows/development.yml/badge.svg?branch=b-7.0.x)](https://github.com/OXID-eSales/graphql-configuration-access/actions/workflows/development.yml)
[![Latest Version](https://img.shields.io/packagist/v/OXID-eSales/graphql-configuration-access?logo=composer&label=latest&include_prereleases&color=orange)](https://packagist.org/packages/oxid-esales/graphql-configuration-access)
[![PHP Version](https://img.shields.io/packagist/php-v/oxid-esales/graphql-configuration-access)](https://github.com/oxid-esales/graphql-configuration-access)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_graphql-configuration-access&metric=alert_status)](https://sonarcloud.io/dashboard?id=OXID-eSales_graphql-configuration-access)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_graphql-configuration-access&metric=coverage)](https://sonarcloud.io/dashboard?id=OXID-eSales_graphql-configuration-access)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=OXID-eSales_graphql-configuration-access&metric=sqale_index)](https://sonarcloud.io/dashboard?id=OXID-eSales_graphql-configuration-access)

# graphql-configuration-access
OXAPI (GraphQL based) access to configuration settings


### Why we use this schema
To fetch and update the configurations we implemented a different query/mutation per value-type.
We have chosen this schema because of GraphQL's strictness which doesn't allow for dynamic types. Without these types,
the API consumer would always have to convert the value after queries or before mutations if, for example,
we decided to use json encoded strings instead.

To get the specific type of a configuration, we provide queries like
`shopSettings`/`moduleSettings`/`themeSettings` to figure out the type for configurations.
As a result you get an array of setting types:

```
type SettingType {
  name: string!
  type: FieldType!
  isSupported: boolean!
}

enum FieldType {
  'str'
  'select'
  'bool'
  'num
  'arr'
  'aarr'
}
```

## Documentation

* Full documentation can be found [here](https://docs.oxid-esales.com/interfaces/graphql/en/latest/).

### Install

Switch to the shop root directory (the file `composer.json` and the directories `source/` and `vendor/` are located there).

```bash
# Install desired version of oxid-esales/graphql-configuration-access module, in this case - latest released 1.x version
$ composer require oxid-esales/graphql-configuration-access ^1.0.0
```

If you didn't have the `oxid-esales/graphql-base` module installed, composer will do that for you.

After installing the module, you need to activate it, either via OXID eShop admin or CLI.

```bash
$ vendor/bin/oe-console oe:module:activate oe_graphql_base
$ vendor/bin/oe-console oe:module:activate oe_graphql_configuration_access
```

### How to use

A good starting point is to check the [How to use section in the GraphQL Base Module](https://github.com/OXID-eSales/graphql-base-module/#how-to-use)

## Testing

### Linting, syntax check, static analysis

```bash
$ composer update
$ composer static
```

### Unit/Integration/Acceptance tests

- install this module into a running OXID eShop
- reset shop's database
```bash
$ bin/oe-console oe:database:reset --db-host=db-host --db-port=db-port --db-name=db-name --db-user=db-user --db-password=db-password --force
```

- run Unit + Integration tests
```bash
$ composer phpunit
```

- run Unit tests
```bash
$ ./vendor/bin/phpunit -c vendor/oxid-esales/graphql-configuration-access/tests/phpunit.xml
```
- run Integration tests
```bash
$ ./vendor/bin/phpunit --bootstrap=./source/bootstrap.php -c vendor/oxid-esales/graphql-configuration-access/tests/phpintegration.xml
```
- run Acceptance tests
```bash
$ composer codeception
```
