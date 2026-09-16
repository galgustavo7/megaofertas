<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand');
            $table->string('asin', 20)->index();
            $table->decimal('price', 10, 2);
            $table->decimal('list_price', 10, 2)->nullable();
            $table->decimal('rating', 3, 1)->default(4.5);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->string('emoji')->default('📦');
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            // Fecha de la última verificación del precio (PA-API o curación manual)
            $table->timestamp('price_updated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
