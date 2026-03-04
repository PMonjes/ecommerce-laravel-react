<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // snapshot del producto en el momento de compra
            $table->string('product_name');
            $table->string('product_sku')->nullable(); // si después agregamos SKU
            $table->unsignedBigInteger('unit_price_cents');
            $table->unsignedInteger('quantity');

            $table->unsignedBigInteger('line_total_cents');

            $table->timestamps();

            $table->index(['order_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};