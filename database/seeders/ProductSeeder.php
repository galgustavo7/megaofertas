<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // ── Tecnología ─────────────────────────────────────────────
            ['cat' => 'tecnologia', 'name' => 'Audífonos Inalámbricos ProSound X9', 'brand' => 'Sony', 'asin' => 'B0A8T2KQ5M', 'price' => 89.99, 'list' => 129.99, 'rating' => 4.7, 'reviews' => 12847, 'emoji' => '🎧', 'featured' => true, 'new' => false,
                'desc' => 'Cancelación activa de ruido híbrida, 30 horas de batería y audio Hi-Res. El favorito de quienes viajan y trabajan en movimiento.'],
            ['cat' => 'tecnologia', 'name' => 'Smartwatch FitTrack S8', 'brand' => 'Garmin', 'asin' => 'B0B3X7PL2R', 'price' => 149.99, 'list' => 199.99, 'rating' => 4.6, 'reviews' => 8342, 'emoji' => '⌚', 'featured' => true, 'new' => false,
                'desc' => 'GPS de doble frecuencia, monitor de salud 24/7 y hasta 15 días de batería. Tu entrenador personal siempre en la muñeca.'],
            ['cat' => 'tecnologia', 'name' => 'Cámara de Seguridad WiFi 2K', 'brand' => 'Eufy', 'asin' => 'B0C1M4WZ8X', 'price' => 59.99, 'list' => 89.99, 'rating' => 4.5, 'reviews' => 21930, 'emoji' => '📹', 'featured' => false, 'new' => false,
                'desc' => 'Resolución 2K, visión nocturna a color y detección de personas con IA. Instálala en 10 minutos, sin mensualidades.'],
            ['cat' => 'tecnologia', 'name' => 'Teclado Mecánico RGB K8', 'brand' => 'Logitech', 'asin' => 'B0D9R6TQ1J', 'price' => 74.99, 'list' => 99.99, 'rating' => 4.8, 'reviews' => 5612, 'emoji' => '⌨️', 'featured' => false, 'new' => true,
                'desc' => 'Switches mecánicos azul, retroiluminación RGB por tecla y base antideslizante. Precisión para gaming y productividad.'],
            ['cat' => 'tecnologia', 'name' => 'Hub de Carga MagSafe 3 en 1', 'brand' => 'Anker', 'asin' => 'B0E2P8VH4L', 'price' => 69.99, 'list' => 99.99, 'rating' => 4.6, 'reviews' => 3408, 'emoji' => '🔌', 'featured' => false, 'new' => false,
                'desc' => 'Carga tu teléfono, smartwatch y audífonos al mismo tiempo con 15W inalámbricos. Plegable y perfecto para viajar.'],

            // ── Hogar ──────────────────────────────────────────────────
            ['cat' => 'hogar', 'name' => 'Lámpara de Sal de Himalaya LED', 'brand' => 'LumiLife', 'asin' => 'B0F5N3JK6P', 'price' => 34.99, 'list' => 49.99, 'rating' => 4.4, 'reviews' => 7221, 'emoji' => '💡', 'featured' => false, 'new' => false,
                'desc' => 'Luz cálida regulable con temporizador de 4 horas. Un toque zen para tu dormitorio o escritorio.'],
            ['cat' => 'hogar', 'name' => 'Aspiradora Robot SmartNav R2', 'brand' => 'iRobot', 'asin' => 'B0G7Q9XT2A', 'price' => 249.99, 'list' => 399.99, 'rating' => 4.5, 'reviews' => 15673, 'emoji' => '🤖', 'featured' => true, 'new' => false,
                'desc' => 'Mapeo láser inteligente, limpieza en dos pasadas y vaciado automático. Pídelo por la app mientras vas a trabajar.'],
            ['cat' => 'hogar', 'name' => 'Humidificador Ultrasónico 4L', 'brand' => 'Coresp', 'asin' => 'B0H4W6MD7C', 'price' => 42.99, 'list' => 59.99, 'rating' => 4.6, 'reviews' => 9118, 'emoji' => '💧', 'featured' => false, 'new' => true,
                'desc' => 'Nebulización fría y caliente, luz ambiental y hasta 24 horas de operación. Silencioso, por debajo de 30 dB.'],
            ['cat' => 'hogar', 'name' => 'Espejo LED de Tocador', 'brand' => 'LumiLife', 'asin' => 'B0J2C8RF3B', 'price' => 46.99, 'list' => 69.99, 'rating' => 4.3, 'reviews' => 4876, 'emoji' => '🪞', 'featured' => false, 'new' => false,
                'desc' => 'Luz de estudio de 3 intensidades, Bluetooth y carga inalámbrica en la base. Tu esquina de belleza como en un salón.'],

            // ── Cocina ─────────────────────────────────────────────────
            ['cat' => 'cocina', 'name' => 'Freidora de Aire Digital 5.5L', 'brand' => 'Philips', 'asin' => 'B0K6T1VG9D', 'price' => 119.99, 'list' => 179.99, 'rating' => 4.7, 'reviews' => 32450, 'emoji' => '🍟', 'featured' => true, 'new' => false,
                'desc' => 'Freír con un 90% menos de aceite gracias a la tecnología Rapid Air. Pantalla digital, 8 programas y limpieza en 30 segundos.'],
            ['cat' => 'cocina', 'name' => 'Licuadora NutriPower 900W', 'brand' => 'Ninja', 'asin' => 'B0L9B4XW5H', 'price' => 99.99, 'list' => 139.99, 'rating' => 4.6, 'reviews' => 18204, 'emoji' => '🥤', 'featured' => false, 'new' => false,
                'desc' => 'Motor de 900W, vaso de 1.3L y programa Smoothie. Tritura hielo y fruta en segundos, sin grumos.'],
            ['cat' => 'cocina', 'name' => 'Set de Ollas Antiadherentes 10 pzas', 'brand' => 'T-fal', 'asin' => 'B0M3D7YQ2K', 'price' => 79.99, 'list' => 119.99, 'rating' => 4.5, 'reviews' => 6782, 'emoji' => '🍲', 'featured' => false, 'new' => true,
                'desc' => 'Acero inoxidable con recubrimiento libre de PFOA, apto para horno y compatible con inducción. Cocina para toda la familia.'],
            ['cat' => 'cocina', 'name' => 'Cafetera Espresso Compacta 15 bar', 'brand' => 'DeLonghi', 'asin' => 'B0N8F2ZS6T', 'price' => 189.99, 'list' => 249.99, 'rating' => 4.6, 'reviews' => 11903, 'emoji' => '☕', 'featured' => false, 'new' => false,
                'desc' => 'Bomba de 15 bares y vaporizador para leche texturizada, con depósito de 1.5L. Café de especialidad sin salir de casa.'],

            // ── Deportes ───────────────────────────────────────────────
            ['cat' => 'deportes', 'name' => 'Set de Bandas Elásticas 5 Niveles', 'brand' => 'GYMIX', 'asin' => 'B0P4H5AV8W', 'price' => 24.99, 'list' => 39.99, 'rating' => 4.4, 'reviews' => 25667, 'emoji' => '🏋️', 'featured' => false, 'new' => false,
                'desc' => '5 niveles de resistencia, 2 asas y 2 manilleras con bolsa de transporte. Entrena en casa, en el hotel o en el parque.'],
            ['cat' => 'deportes', 'name' => 'Botella Térmica 1L de Acero', 'brand' => 'HydroFlask', 'asin' => 'B0Q7J8CW3Y', 'price' => 39.99, 'list' => 54.99, 'rating' => 4.7, 'reviews' => 14328, 'emoji' => '🧊', 'featured' => false, 'new' => false,
                'desc' => 'Mantiene el frío 24 h y el calor 12 h. Doble pared al vacío, sin BPA y con tapa a prueba de fugas.'],
            ['cat' => 'deportes', 'name' => 'Mancuernas Ajustables 2x12kg', 'brand' => 'PowerBlock', 'asin' => 'B0R1L3DX9Z', 'price' => 159.99, 'list' => 219.99, 'rating' => 4.8, 'reviews' => 4519, 'emoji' => '🏋️', 'featured' => true, 'new' => false,
                'desc' => 'Equivalen a 15 pares de mancuernas: ajusta de 2.5 a 12 kg con un clic. Fuerza de gimnasio en un metro cuadrado.'],
            ['cat' => 'deportes', 'name' => 'Alfombra de Yoga Antideslizante', 'brand' => 'Manduka', 'asin' => 'B0S5N6FY4A', 'price' => 49.99, 'list' => 79.99, 'rating' => 4.6, 'reviews' => 8942, 'emoji' => '🧘', 'featured' => false, 'new' => false,
                'desc' => 'EVA de doble densidad de 6 mm con línea de alineación central y correa de transporte. Amable con pies y rodillas.'],

            // ── Belleza ────────────────────────────────────────────────
            ['cat' => 'belleza', 'name' => 'Secador de Cabello Iónico 2200W', 'brand' => 'Dyson', 'asin' => 'B0T8P9GZ7B', 'price' => 429.99, 'list' => 499.99, 'rating' => 4.9, 'reviews' => 22185, 'emoji' => '💨', 'featured' => true, 'new' => false,
                'desc' => 'Motor de 110,000 RPM, control de temperatura inteligente y 5 peines magnéticos. Seca más rápido con la mitad del daño.'],
            ['cat' => 'belleza', 'name' => 'Kit de Brochas de Maquillaje 12 pzas', 'brand' => 'RealTechniques', 'asin' => 'B0U2R4HA1C', 'price' => 29.99, 'list' => 44.99, 'rating' => 4.5, 'reviews' => 16730, 'emoji' => '🖌️', 'featured' => false, 'new' => false,
                'desc' => 'Pelo sintético de alta densidad para base, colorete, ojos y labios, con estuche rígido para viajar.'],
            ['cat' => 'belleza', 'name' => 'Afeitadora Eléctrica 5D', 'brand' => 'Philips', 'asin' => 'B0V6T7JB5D', 'price' => 89.99, 'list' => 129.99, 'rating' => 4.6, 'reviews' => 9481, 'emoji' => '🪒', 'featured' => false, 'new' => false,
                'desc' => '5 sistemas de corte que se adaptan a tu rostro, uso en húmedo o seco y 60 minutos de batería.'],
            ['cat' => 'belleza', 'name' => 'Set de Masaje Facial con Jade', 'brand' => 'StoneCare', 'asin' => 'B0W9X1KC8E', 'price' => 19.99, 'list' => 29.99, 'rating' => 4.3, 'reviews' => 12067, 'emoji' => '💆', 'featured' => false, 'new' => true,
                'desc' => 'Rodillo de jade y gua sha para reducir la hinchazón y mejorar la circulación. Ritual de skincare en 5 minutos.'],

            // ── Oficina ────────────────────────────────────────────────
            ['cat' => 'oficina', 'name' => 'Silla Ergonómica con Soporte Lumbar', 'brand' => 'Hbada', 'asin' => 'B0Y3Z6LD2F', 'price' => 139.99, 'list' => 199.99, 'rating' => 4.5, 'reviews' => 7854, 'emoji' => '🪑', 'featured' => true, 'new' => false,
                'desc' => 'Malla transpirable, soporte lumbar ajustable, reposabrazos 4D y cabecera reclinable hasta 135°. Para jornadas largas.'],
            ['cat' => 'oficina', 'name' => 'Soporte para Laptop de Aluminio', 'brand' => 'Roostave', 'asin' => 'B0Z7A8ME5G', 'price' => 32.99, 'list' => 45.99, 'rating' => 4.7, 'reviews' => 19342, 'emoji' => '💻', 'featured' => false, 'new' => true,
                'desc' => 'Aluminio aeroespacial con 6 alturas ajustables, canal para cableado y agarre de goma antideslizante.'],
            ['cat' => 'oficina', 'name' => 'Impresora Multifunción WiFi', 'brand' => 'Epson', 'asin' => 'B1A2B5NF9H', 'price' => 159.99, 'list' => 219.99, 'rating' => 4.6, 'reviews' => 6210, 'emoji' => '🖨️', 'featured' => false, 'new' => false,
                'desc' => 'Imprime, escanea y copia desde el móvil con EcoTank: el tóner rinde hasta un año y ahorras hasta un 90% en tinta.'],

            // ── Juguetes ───────────────────────────────────────────────
            ['cat' => 'juguetes', 'name' => 'Set de Construcción 1200 Piezas', 'brand' => 'BrickMaster', 'asin' => 'B1C6D9PG3J', 'price' => 69.99, 'list' => 99.99, 'rating' => 4.8, 'reviews' => 5109, 'emoji' => '🧱', 'featured' => false, 'new' => false,
                'desc' => 'Compatible con las marcas líderes, incluye minifiguras, guía digital y caja de almacenamiento. Horas de creatividad garantizadas.'],
            ['cat' => 'juguetes', 'name' => 'Drone con Cámara 4K Plegable', 'brand' => 'HoverAir', 'asin' => 'B1E1F3QH7K', 'price' => 129.99, 'list' => 189.99, 'rating' => 4.5, 'reviews' => 3876, 'emoji' => '🚁', 'featured' => true, 'new' => true,
                'desc' => 'Cámara 4K estabilizada, 25 minutos de vuelo, control por gestos y retorno automático. Incluye 2 baterías.'],
            ['cat' => 'juguetes', 'name' => 'Peluche Oso Gigante 1 metro', 'brand' => 'TeddyJoy', 'asin' => 'B1G5H7RQ1L', 'price' => 44.99, 'list' => 59.99, 'rating' => 4.9, 'reviews' => 28931, 'emoji' => '🧸', 'featured' => false, 'new' => false,
                'desc' => 'Suave como una nube, 1 metro de altura y relleno hipoalergénico. El abrazo más grande que existe.'],

            // ── Libros ─────────────────────────────────────────────────
            ['cat' => 'libros', 'name' => 'Hábitos Atómicos (Ed. en español)', 'brand' => 'James Clear', 'asin' => 'B1I9J2SS5M', 'price' => 15.99, 'list' => 24.99, 'rating' => 4.8, 'reviews' => 54217, 'emoji' => '📚', 'featured' => true, 'new' => false,
                'desc' => 'El best-seller que cambió la forma en que millones de personas construyen buenos hábitos y abandonan los malos.'],
            ['cat' => 'libros', 'name' => 'Trabajo Profundo (Ed. en español)', 'brand' => 'Cal Newport', 'asin' => 'B1K3L6TT8N', 'price' => 16.99, 'list' => 25.99, 'rating' => 4.7, 'reviews' => 18554, 'emoji' => '📖', 'featured' => false, 'new' => false,
                'desc' => 'Por qué la concentración es la habilidad más valiosa del siglo XXI y cómo entrenarla en un mundo de distracciones.'],
            ['cat' => 'libros', 'name' => 'Cuaderno Puntillado A5 192 pág', 'brand' => 'PaperBlanks', 'asin' => 'B1M7M9UU2P', 'price' => 18.99, 'list' => 24.99, 'rating' => 4.9, 'reviews' => 21440, 'emoji' => '✍️', 'featured' => false, 'new' => false,
                'desc' => 'Papel ahuesado de 120 g sin ghosting, tapa dura y elástico de cierre. Perfecto para bullet journal y esbozos.'],
        ];

        foreach ($products as $data) {
            $category = Category::where('slug', $data['cat'])->firstOrFail();

            $product = Product::firstOrNew(['asin' => $data['asin']]);
            $product->fill([
                'category_id' => $category->id,
                'name' => $data['name'],
                'slug' => Product::uniqueSlug($data['name'], $product->id),
                'brand' => $data['brand'],
                'price' => $data['price'],
                'list_price' => $data['list'],
                'rating' => $data['rating'],
                'reviews_count' => $data['reviews'],
                'emoji' => $data['emoji'],
                'description' => $data['desc'],
                'is_featured' => $data['featured'],
                'is_new' => $data['new'],
                'price_updated_at' => now()->subDays(mt_rand(0, 5)),
            ])->save();
        }
    }
}
