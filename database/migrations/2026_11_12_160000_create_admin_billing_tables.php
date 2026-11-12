<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('payment_gateways')) {
            Schema::create('payment_gateways', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('name');
                $table->string('group')->default('aggregators');
                $table->boolean('enabled')->default(false);
                $table->boolean('test_mode')->default(true);
                $table->unsignedInteger('min_amount_cents')->default(100);
                $table->unsignedInteger('sort')->default(100);
                $table->json('config')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('payment_orders')) {
            Schema::create('payment_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('gateway_code', 64);
                $table->unsignedBigInteger('amount_cents');
                $table->string('currency', 8)->default('USD');
                $table->string('status', 32)->default('pending'); // pending, paid, failed, expired, refunded
                $table->string('idempotency_key')->unique();
                $table->string('external_id')->nullable()->index();
                $table->string('pay_url', 2048)->nullable();
                $table->json('meta')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->timestamps();
                $table->index(['status', 'created_at']);
                $table->index(['user_id', 'created_at']);
            });
        }

        if (! Schema::hasTable('system_settings')) {
            Schema::create('system_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->json('value')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('payment_orders');
        Schema::dropIfExists('payment_gateways');
    }
};
