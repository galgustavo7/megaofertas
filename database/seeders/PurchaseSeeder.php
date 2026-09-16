<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        if (Purchase::query()->exists()) {
            return;
        }

        mt_srand(20260916);

        $rates = [
            'tecnologia' => 0.04, 'hogar' => 0.045, 'cocina' => 0.045, 'deportes' => 0.045,
            'belleza' => 0.05, 'oficina' => 0.04, 'juguetes' => 0.03, 'libros' => 0.03,
        ];

        $names = [
            'María González', 'Carlos Rodríguez', 'Ana Martínez', 'Luis Hernández', 'Carmen Torres',
            'José Ramírez', 'Lucía Fernández', 'Miguel Sánchez', 'Sofía Ramírez', 'Andrés Morales',
            'Valentina Rojas', 'Diego Castillo', 'Camila Vargas', 'Fernando Ortega', 'Isabella Cruz',
            'Ricardo Mendoza', 'Paula Navarro', 'Javier Paredes', 'Daniela Ríos', 'Alejandro Silva',
        ];

        $products = Product::with('category')->get();
        $now = now();
        $rows = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = $now->copy()->subMonthsNoOverflow($i);
            $isCurrent = $i === 0;
            // Tendencia de crecimiento: ~10-16 pedidos en el mes más viejo hasta ~28-34 en el actual
            $count = 10 + (11 - $i) * 2 + mt_rand(0, 6);

            for ($j = 0; $j < $count; $j++) {
                $product = $products[mt_rand(0, $products->count() - 1)];
                $day = $isCurrent ? mt_rand(1, max(1, $now->day)) : mt_rand(1, $month->daysInMonth);
                $date = $month->copy()->day($day)->format('Y-m-d');

                $r = mt_rand(1, 100);
                $status = $r <= 68 ? 'aprobado' : ($r <= 82 ? 'pendiente' : ($r <= 90 ? 'nuevo' : 'reversado'));

                $name = $names[mt_rand(0, count($names) - 1)];
                $amount = (float) $product->price;
                $rate = $rates[$product->category->slug] ?? 0.04;

                $rows[] = [
                    'product_id' => $product->id,
                    'customer_name' => $name,
                    'customer_email' => strtolower(str_replace(' ', '.', $name)).'@gmail.com',
                    'amount' => $amount,
                    'commission' => round($amount * $rate, 2),
                    'status' => $status,
                    'purchase_date' => $date,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        Purchase::query()->insert($rows);
    }
}
