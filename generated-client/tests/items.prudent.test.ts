
import * as dotenv from 'dotenv';
dotenv.config();

import { Configuration, ItemsApi } from '../../generated-client';
const config = new Configuration({ basePath: process.env.API_URL || 'http://127.0.0.1:8000/api/v1' });
const api = new ItemsApi(config);

// Ajusta estos valores a los que existan en tu DB de pruebas
const EXISTING_SKU = 'SKU-001';
const NON_EXISTENT_SKU = 'SKU-XXX';

describe('Tejidos API (pruebas básicas)', () => {

  it('GET /items devuelve 200 y array', async () => {
    const resp = await api.getAllItems();
    expect(resp.status).toBe(200);
    expect(Array.isArray(resp.data.data || resp.data)).toBeTruthy();
  });

  it('GET /items/{sku} devuelve 404 si no existe', async () => {
    await expect(api.getItemBySku(NON_EXISTENT_SKU)).rejects.toThrow(/404/);
  });

});
