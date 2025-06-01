# ItemWithVariants


## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**sku** | **number** |  | [default to undefined]
**title** | **string** |  | [default to undefined]
**description** | **string** |  | [optional] [default to undefined]
**status** | **string** |  | [optional] [default to StatusEnum_Active]
**min_price** | **number** |  | [optional] [default to undefined]
**available_colors** | **Array&lt;string&gt;** |  | [optional] [default to undefined]
**available_sizes** | **Array&lt;string&gt;** |  | [optional] [default to undefined]

## Example

```typescript
import { ItemWithVariants } from './api';

const instance: ItemWithVariants = {
    sku,
    title,
    description,
    status,
    min_price,
    available_colors,
    available_sizes,
};
```

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)
