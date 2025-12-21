<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('email_verifications', function (Blueprint $table) {
            $table->string('email')->after('id')->unique();
            $table->string('name')->after('email');
            $table->string('password')->after('name');
            $table->string('phone')->nullable()->after('password');
            $table->string('address')->nullable()->after('phone');

            // Nếu muốn, có thể bỏ foreign key user_id, hoặc giữ lại cho tương thích
        });
    }

    public function down(): void
    {
        Schema::table('email_verifications', function (Blueprint $table) {
            $table->dropColumn(['email', 'name', 'password', 'phone', 'address']);
        });
    }
};
