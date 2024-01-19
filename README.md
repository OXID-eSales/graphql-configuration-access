
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
