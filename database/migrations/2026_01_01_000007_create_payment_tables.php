<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('service_provider_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_id')->nullable()->constrained();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax_rate', 5, 2)->default(15.00);
            $table->decimal('tax_amount', 12, 2);
            $table->decimal('total', 12, 2);
            $table->enum('status', ['unpaid', 'paid', 'void', 'refunded'])->default('unpaid');
            $table->timestamp('due_at')->nullable();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->string('transaction_ref')->unique();
            $table->enum('method', ['visa', 'mastercard', 'mada', 'apple_pay', 'bank_transfer']);
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->json('gateway_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('invoices');
    }
};
