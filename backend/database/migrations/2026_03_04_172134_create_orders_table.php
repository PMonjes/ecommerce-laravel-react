<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // estados base (los iremos usando en pagos)
            $table->string('status')->default('pending_payment');
            // pending_payment | paid | failed | cancelled | refunded | shipped

            $table->unsignedBigInteger('subtotal_cents')->default(0);
            $table->unsignedBigInteger('shipping_cents')->default(0);
            $table->unsignedBigInteger('discount_cents')->default(0);
            $table->unsignedBigInteger('total_cents')->default(0);

            // datos simples de envío (MVP)
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_phone')->nullable();

            // proveedor de pago (webpay, mercadopago, stripe)
            $table->string('payment_provider')->nullable();
            $table->string('payment_reference')->nullable(); // token/transaction id

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};