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
