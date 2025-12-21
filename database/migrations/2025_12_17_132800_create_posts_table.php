<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('code', 50)->unique(); // Mã bài viết (POST001)
            $table->string('title', 200);
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Mô tả ngắn
            $table->longText('content_post');          // Nội dung
            $table->string('thumbnail')->nullable(); // Ảnh đại diện

            $table->foreignId('post_category_id')
                  ->constrained('post_categories')
                  ->cascadeOnDelete();

            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
