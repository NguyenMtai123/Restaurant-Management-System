<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->enum('order_type', ['delivery','takeaway','dine-in'])->default('dine-in');
            $table->foreignId('table_id')->nullable()->constrained('tables');
            $table->decimal('total', 12, 3)->default(0);
            $table->decimal('discount', 12, 3)->default(0);
            $table->decimal('final_total', 12, 3)->default(0);
            $table->enum('status', ['pending','preparing','delivering','completed','cancelled'])->default('pending');
            $table->string('address', 500)->nullable();
            $table->foreignId('shipping_zone_id')->nullable()->constrained('shipping_zones');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('menu_items')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
