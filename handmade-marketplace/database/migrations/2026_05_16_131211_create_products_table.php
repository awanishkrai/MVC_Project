<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->string('category')->nullable();
            $table->boolean('is_made_to_order')->default(false);
            $table->string('status')->default('draft');
            $table->json('tags')->nullable();
            $table->string('materials')->nullable();
            $table->string('dimensions')->nullable();
            $table->text('shipping_info')->nullable();
            $table->text('return_policy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
