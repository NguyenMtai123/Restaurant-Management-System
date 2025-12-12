<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('table_id')->constrained('restaurant_tables')->cascadeOnDelete();

            $table->date('booking_date');
            $table->time('booking_time');
            $table->integer('number_of_guests')->check('number_of_guests > 0');

            $table->decimal('deposit_fee', 10, 2)->default(0)->check('deposit_fee >= 0');
            $table->boolean('deposit_paid')->default(false);

            $table->text('special_requests')->nullable();

            $table->enum('status', ['pending','confirmed','cancelled','completed'])
                  ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
