# graphql-configuration-access
OXAPI (GraphQL based) access to configuration settings


### Why we use this schema
To get and update the configurations we implemented a different query/mutation per each value-type.
We choose this schema, because GraphQL is very strict and doesn't allow dynamic types. Without these strict types,
the user would always have to convert the value after queries or before mutations.

To get the specific type of a configuration, we provide queries like
`getShopSettingsList`/`getModuleSettingsList`/`getThemeSettingsList` to figure out the type for configurations.
As a result you get an array of `SettingType`'s:

```
type SettingType {
  name: ID!
  description: String!
  type: FieldType!
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
