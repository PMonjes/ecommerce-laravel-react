<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('provider'); // webpay | mercadopago | stripe
            $table->string('status')->default('created');
            // created | redirected | authorized | paid | failed | refunded

            $table->unsignedBigInteger('amount_cents');

            // IDs de la pasarela
            $table->string('provider_transaction_id')->nullable();
            $table->string('provider_token')->nullable();

            // payloads (guardamos JSON para auditoría/debug)
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();

            $table->timestamps();

            $table->index(['provider', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};