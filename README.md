# ⚡ MegaOfertas — Tienda de afiliados de Amazon (Laravel 13)

<p>
  <img alt="Laravel" src="https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white" />
  <img alt="PHP" src="https://img.shields.io/badge/PHP-%E2%89%A5%208.3-777BB4?logo=php&logoColor=white" />
  <img alt="SQLite" src="https://img.shields.io/badge/SQLite-database-003B57?logo=sqlite&logoColor=white" />
  <img alt="Chart.js" src="https://img.shields.io/badge/Chart.js-4.x-FF6384?logo=chartdotjs&logoColor=white" />
  <img alt="Licencia" src="https://img.shields.io/badge/License-MIT-yellow.svg" />
  <img alt="Estado" src="https://img.shields.io/badge/Estado-activo-10B981" />
</p>

Tienda de marketing de afiliados construida con **Laravel 13**, diseño moderno responsivo tipo app,
panel de administración con **dashboard de compras y gráfica de estadísticas**, y **cumplimiento total
de las reglas de Amazon Associates sobre precios**.

## ✨ Características

### Tienda pública
- **Home moderna**: hero con buscador, categorías, carrusel de destacados (scroll-snap tipo app),
  top descuentos, mejor valorados, testimonios y newsletter.
- **Catálogo** con filtros: búsqueda, categoría, rango de precio, orden (popular, precio, rating,
  descuento) y "solo ofertas". Paginación.
- **Página de producto** con precio de referencia, fecha de verificación, aviso legal obligatorio,
  meta ASIN y enlace directo a Amazon con tag de afiliado.
- **Promociones** (mayor % de descuento) y **Reseñas Top** (mejor valorados).
- **Contacto** con formulario que guarda mensajes en base de datos.
- **Header** con menú completo: Inicio · Tienda · 🔥 Promociones · Reseñas Top · Categorías (dropdown) · Contacto.
- **Bottom-nav fija en móvil** (Inicio / Tienda / Ofertas / Reseñas / Contacto) — experiencia tipo app.
- Responsive: desktop, tablet y móvil (breakpoints 1080/900/860/768/560 px).

### Panel de administración (super usuario)
- **Login** restringido a usuarios con `is_super` (middleware `admin`).
- **Dashboard**: 4 KPIs del mes con delta vs mes anterior, **gráfica combinada de 12 meses**
  (barras = ingresos, línea = comisión, Chart.js), doughnut de estados de compra,
  Top 5 productos por ingresos y últimos pedidos.
- **Productos**: CRUD completo con búsqueda y filtros.
- **Categorías**: crear / editar / eliminar (con protecciones).
- **Compras**: revisión de todas las compras, filtros por estado/mes/cliente,
  cambio de estado inline y **exportación a CSV**.
- **Ajustes**: nombre de tienda, tag de afiliado, host de Amazon, moneda y
  los textos legales obligatorios (disclaimer de precios + disclosura de afiliado).

## 🔐 Credenciales demo

| Rol | Email | Contraseña |
|---|---|---|
| Super usuario | `admin@megaofertas.com` | `admin1234` |

URL del panel: `/admin/login`

## 🚀 Puesta en marcha

```bash
composer install
php artisan key:generate
cp .env.example .env          # si partas de cero (aquí ya está configurado SQLite)
php artisan migrate:fresh --seed
php scripts/generate_images.php   # genera las imágenes SVG de los productos
php artisan serve --host=0.0.0.0 --port=8000
```

### Variables de `.env` para precios en vivo (opcional)
```env
AMAZON_ACCESS_KEY_ID=...
AMAZON_SECRET_ACCESS_KEY=...
AMAZON_ASSOCIATE_TAG=megaofertas-21
AMAZON_PA_HOST=webservices.amazon.com
AMAZON_PA_REGION=us-east-1
AMAZON_PA_MARKETPLACE=ATVPDKIKX0DER
```

## 🛡️ Cumplimiento de las reglas de Amazon sobre precios

Amazon **prohíbe** mostrar precios en sitios de afiliados si no se obtienen de su
**Product Advertising API (PA-API 5.0)**, y exige avisos claros de que el precio puede variar.
Esta tienda aplica las reglas así:

| Regla | Cómo se cumple |
|---|---|
| Precios solo desde la API oficial | `app/Services/AmazonService.php` implementa PA-API 5.0 con firma **AWS SigV4**. El comando `php artisan amazon:sync` lo ejecuta (scheduler: diario a las 06:00). Sin credenciales, no se fabrica ningún precio "en vivo". |
| Nunca presentar un precio viejo como actual | Cada precio guardado lleva `price_updated_at` (última verificación) y la UI siempre lo muestra. |
| Aviso legal obligatorio | Todos los productos (tarjeta, página de producto, home) muestran: *"Precio de referencia · verificado el {fecha}. El precio final es el que muestre Amazon en el momento de la compra."* |
| Disclosura de afiliado | El footer incluye la disclosura requerida: *"Como Asociado de Amazon, MegaOfertas obtiene ingresos por las compras adscritas que cumplen los requisitos aplicables."* |
| Enlaces de afiliado correctos | Todo enlace a Amazon lleva la **tag** configurada y `rel="nofollow sponsored noopener"` + `target="_blank"`. |
| Sin webscraping | La única vía de actualización es PA-API (nunca scraping de páginas de Amazon, que además viola sus términos). |

> En el panel → **Ajustes** verás el estado de la sincronización y el botón
> "Sincronizar precios ahora" (mismo servicio, mismo camino conforme).

## 🗂️ Estructura clave

```
app/
  Console/Commands/AmazonSyncPrices.php   # amazon:sync
  Http/Controllers/                       # Tienda pública + Admin
  Http/Middleware/EnsureSuperUser.php     # middleware "admin"
  Models/                                 # Product, Category, Purchase, Setting, Contact, User
  Services/AmazonService.php              # PA-API 5.0 + SigV4
  Support/Price.php                       # formato de moneda
database/
  migrations/                             # + is_super en users
  seeders/                                # 8 categorías, 30 productos, ~230 compras (12 meses)
public/
  css/store.css                           # todo el diseño (store + admin), responsive
  js/main.js, admin.js, chart.umd.min.js  # Chart.js vendado local (sin CDN)
  images/products/*.svg                   # imágenes generadas
resources/views/
  layouts/app.blade.php                   # header/footer/bottom-nav
  parts/product-card.blade.php            # tarjeta reutilizable
  store/  home  contact                   # tienda pública
  admin/                                  # panel completo
scripts/generate_images.php               # genera las SVG de productos
```

## 📝 Notas

- Base de datos: **SQLite** (archivo `database/database.sqlite`).
- Las imágenes de producto son SVG locales (gradiente de la categoría + emoji),
  generadas por `scripts/generate_images.php`; puedes reemplazarlas por fotos reales
  en `public/images/products/{slug}.svg`.
- Los ASIN y cifras de reseñas de la semilla son de demostración: cámbialos en el panel.

## 📄 Licencia

Este proyecto está bajo la licencia [MIT](LICENSE) — puedes usarlo, modificarlo y distribuirlo libremente.
