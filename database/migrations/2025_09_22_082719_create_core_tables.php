<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->timestamps();
        });

        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->foreignId('category_id')->constrained('categories')
                ->cascadeOnUpdate()->restrictOnDelete();
            $t->unsignedInteger('stock')->default(0);
            $t->decimal('price', 12, 2);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
            $t->index(['name','category_id']);
        });

        Schema::create('carts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->timestamps();
            $t->unique('user_id'); // satu keranjang per user
        });

        Schema::create('cart_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('cart_id')->constrained('carts')->cascadeOnDelete();
            $t->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $t->unsignedInteger('qty');
            $t->timestamps();
            $t->unique(['cart_id','product_id']);
        });

        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->decimal('total', 14, 2)->default(0);
            $t->enum('status',['diproses','dikirim','selesai','batal'])->default('diproses');
            $t->text('address_text');
            $t->timestamps();
            $t->index(['user_id','status']);
        });

        Schema::create('order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $t->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $t->decimal('price', 12, 2);
            $t->unsignedInteger('qty');
            $t->decimal('subtotal', 14, 2);
            $t->timestamps();
            $t->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
