# ItemsApi

All URIs are relative to *http://localhost:8000/v1*

|Method | HTTP request | Description|
|------------- | ------------- | -------------|
|[**getAllItems**](#getallitems) | **GET** /items | Listar todos los productos|
|[**getItemBySku**](#getitembysku) | **GET** /items/{sku} | Obtener producto específico|

# **getAllItems**
> GetAllItems200Response getAllItems()


### Example

```typescript
import {
    ItemsApi,
    Configuration
} from './api';

const configuration = new Configuration();
const apiInstance = new ItemsApi(configuration);

let page: number; //Número de página (optional) (default to 1)
let limit: number; //Límite de items por página (optional) (default to 15)

const { status, data } = await apiInstance.getAllItems(
    page,
    limit
);
```

### Parameters

|Name | Type | Description  | Notes|
|------------- | ------------- | ------------- | -------------|
| **page** | [**number**] | Número de página | (optional) defaults to 1|
| **limit** | [**number**] | Límite de items por página | (optional) defaults to 15|


### Return type

**GetAllItems200Response**

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
|**200** | Lista de productos |  * X-RateLimit-Remaining - Peticiones restantes <br>  * Cache-Control -  <br>  * X-RateLimit-Limit - Límite de peticiones <br>  |
|**500** | Error del servidor |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getItemBySku**
> ItemWithDetails getItemBySku()


### Example

```typescript
import {
    ItemsApi,
    Configuration
} from './api';

const configuration = new Configuration();
const apiInstance = new ItemsApi(configuration);

let sku: string; // (default to undefined)

const { status, data } = await apiInstance.getItemBySku(
    sku
);
```

### Parameters

|Name | Type | Description  | Notes|
|------------- | ------------- | ------------- | -------------|
| **sku** | [**string**] |  | defaults to undefined|


### Return type

**ItemWithDetails**

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json


### HTTP response details
| Status code | Description | Response headers |
|-------------|-------------|------------------|
|**200** | Detalles del producto |  -  |
|**404** | Producto no encontrado |  -  |

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

