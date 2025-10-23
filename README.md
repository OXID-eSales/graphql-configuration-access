
[![Development](https://github.com/OXID-eSales/graphql-configuration-access/actions/workflows/trigger.yml/badge.svg?branch=b-7.0.x)](https://github.com/OXID-eSales/graphql-configuration-access/actions/workflows/trigger.yml)
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

## Branch compatibility

* b-7.4.x branch is compatible with OXID eShop compilation b-7.4.x (which uses `graphql-base` b-7.4.x branch)
* 2.1.x versions (or b-7.3.x branch) are compatible with OXID eShop compilation b-7.3.x (which uses `graphql-base` 11.x version resp. b-7.3.x branch)
* 1.2.x + 2.0.x versions (or b-7.2.x branch) are compatible with OXID eShop compilation b-7.2.x (which uses `graphql-base` 10.x version resp. b-7.2.x branch)
* 1.1.x versions (or b-7.1.x branch) are compatible with OXID eShop compilation b-7.1.x (which uses `graphql-base` 9.x version resp. b-7.1.x branch)

## Documentation

* Full documentation can be found [here](https://docs.oxid-esales.com/interfaces/graphql/en/latest/).

### Install

Switch to the shop root directory (the file `composer.json` and the directories `source/` and `vendor/` are located there).

```bash
# Install desired version of oxid-esales/graphql-configuration-access module, in this case - latest released 2.x version
$ composer require oxid-esales/graphql-configuration-access ^2.0.0
```

If you didn't have the `oxid-esales/graphql-base` module installed, composer will do that for you.

After installing the module, you need to activate it, either via OXID eShop admin or CLI.

```bash
$ vendor/bin/oe-console oe:module:activate oe_graphql_base
$ vendor/bin/oe-console oe:module:activate oe_graphql_configuration_access
```

### How to use

A good starting point is to check the [How to use section in the GraphQL Base Module](https://github.com/OXID-eSales/graphql-base-module/#how-to-use)

## Blocking modules from de/activation via GraphQL

The file module_blockilst.yaml contains a list of modules which are necessary to handle configurations or de/activate
modules via GraphQL or should be blocked for de/activation via GraphQL in general. Modules like ``oe_graphql_base`` and
``oe_graphql_configuration_access`` are listed there.

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

# Development installation on OXID eShop SDK

The installation instructions below are shown for the current [SDK](https://github.com/OXID-eSales/docker-eshop-sdk)
for shop 7.4. Make sure your system meets the requirements of the SDK.

0. Ensure all docker containers are down to avoid port conflicts

1. Clone the SDK for the new project
```shell
echo MyProject && git clone https://github.com/OXID-eSales/docker-eshop-sdk.git $_ && cd $_
```

2. Clone the repository to the source directory
```shell
git clone --recurse-submodules https://github.com/OXID-eSales/graphql-configuration-access.git --branch=b-7.4.x ./source
```

3. Run the recipe to setup the development environment
```shell
./source/recipes/setup-development.sh
```

You should be able to access the shop with http://localhost.local and the admin panel with http://localhost.local/admin
(credentials: noreply@oxid-esales.com / admin)

### Running tests locally

Check the "scripts" section in the `composer.json` file for the available commands. Those commands can be executed
by connecting to the php container and running the command from there, example:

```shell
make php
composer tests-coverage
```

Commands can be also triggered directly on the container with docker compose, example:

```shell
docker compose exec -T php composer tests-coverage
```

