# InventarioApi

All URIs are relative to *https://api.tejidosartesanales.com/v1*

|Method | HTTP request | Description|
|------------- | ------------- | -------------|
|[**getItemInventory**](#getiteminventory) | **GET** /items/{sku}/inventory | Listar variantes de inventario|

# **getItemInventory**
> Array<InventoryWithDetails> getItemInventory()


### Example

```typescript
import {
    InventarioApi,
    Configuration
} from './api';

const configuration = new Configuration();
const apiInstance = new InventarioApi(configuration);

let sku: number; // (default to undefined)

const { status, data } = await apiInstance.getItemInventory(
    sku
);
```

### Parameters

|Name | Type | Description  | Notes|
|------------- | ------------- | ------------- | -------------|
| **sku** | [**number**] |  | defaults to undefined|


### Return type

**Array<InventoryWithDetails>**

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
|**200** | Lista de variantes |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

