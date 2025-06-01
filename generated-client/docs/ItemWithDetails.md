# ItemWithDetails


## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**sku** | **string** |  | [default to undefined]
**title** | **string** |  | [default to undefined]
**description** | **string** |  | [optional] [default to undefined]
**status** | **string** |  | [optional] [default to StatusEnum_Active]
**min_price** | **number** |  | [optional] [default to undefined]
**available_colors** | **Array&lt;string&gt;** |  | [optional] [default to undefined]
**available_sizes** | **Array&lt;string&gt;** |  | [optional] [default to undefined]
**inventories** | [**Array&lt;InventoryWithDetails&gt;**](InventoryWithDetails.md) |  | [optional] [default to undefined]

## Example

```typescript
import { ItemWithDetails } from './api';

const instance: ItemWithDetails = {
    sku,
    title,
    description,
    status,
    min_price,
    available_colors,
    available_sizes,
    inventories,
};
```

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)
