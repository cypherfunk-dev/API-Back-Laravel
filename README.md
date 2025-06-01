
# Tejidos Artesanales API

> **Tiempo total de arranque:** ≈ 5 min  

---

## 1️⃣ Requisitos

| Programa               | Versión mínima |
|------------------------|----------------|
| PHP                    | ≥ 8.2 |
| Composer               | ≥ 2 |
| Node (opcional / assets) | ≥ 18 |
| MySQL / MariaDB        | ≥ 10.6 |
| Docker + Docker Compose | (opcional) |

---

## 2️⃣ Instalación rápida

```bash
git clone https://github.com/tu-org/tejidos-api.git
cd tejidos-api

# Dependencias PHP
composer install

# (Opcional) compilar assets Front-End
npm install && npm run build

# Variables de entorno
cp .env.example .env
php artisan key:generate
```

> Ajusta en **.env**:  
> `DB_*`, `CACHE_DRIVER=redis`, `APP_URL=http://127.0.0.1:8000`

---

## 3️⃣ Base de datos

```bash
php artisan migrate --seed
# Con Docker
docker compose up -d db && php artisan migrate --seed
```

---

## 4️⃣ Documentación Swagger + limpieza de caché

```bash
php artisan config:clear
php artisan l5-swagger:generate
```

Accede a `http://127.0.0.1:8000/api/documentation`

---

## 5️⃣ Servidor de desarrollo

```bash
php artisan serve        # http://127.0.0.1:8000

---

## 6️⃣ Colas y caché (opcional)

```bash
# Redis local
redis-server &
# o con Docker
docker compose up -d redis

# Worker de colas
php artisan queue:work
```

---

## 7️⃣ Tests en el cliente

Ingresa a la carpeta generated-cliente y ejecuta
```bash
npx jest
```

---

## 8️⃣ Producción

```bash
php artisan migrate --force
php artisan config:cache route:cache view:cache
```

---

## ⚡ Optimización por defecto

* **Caché**: todas las rutas **GET** usan `Cache::remember` por 60 min.  
* **Rate-limiting**: middleware `throttle:5,1` — máx. **5 peticiones por minuto** por IP.

---

## 🛠️ Generación de código (OpenAPI Generator)

```bash
# Cliente TypeScript (axios)
openapi-generator generate -i swagger.yaml -g typescript-axios -o ./generated-client

# Servidor Laravel (PHP)
openapi-generator generate -i swagger.yaml -g php-laravel -o ./generated-server
```
