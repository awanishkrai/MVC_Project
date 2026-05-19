<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->string('title')->nullable();
            $table->text('comment');
            $table->boolean('is_verified_purchase')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'product_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('average_rating', 3, 2)->nullable()->after('status');
            $table->unsignedInteger('reviews_count')->default(0)->after('average_rating');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['average_rating', 'reviews_count']);
        });

        Schema::dropIfExists('reviews');
    }
};
