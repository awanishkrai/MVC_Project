<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->after('shop_id')->constrained()->nullOnDelete();
            $table->string('slug')->nullable()->after('title');
            $table->string('handmade_material')->nullable()->after('quantity');
            $table->string('delivery_time')->nullable()->after('handmade_material');
            $table->string('image')->nullable()->after('delivery_time');
            $table->string('stock_status')->default('in_stock')->after('image');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['category_id']);
            $table->dropColumn([
                'user_id', 'category_id', 'slug', 'handmade_material',
                'delivery_time', 'image', 'stock_status',
            ]);
        });
    }
};
