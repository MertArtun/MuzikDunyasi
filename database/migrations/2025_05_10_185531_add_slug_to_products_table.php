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
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->after('name')->unique()->nullable();
            // stock_quantity yerine stock değiştirildi
            if (Schema::hasColumn('products', 'stock_quantity') && !Schema::hasColumn('products', 'stock')) {
                $table->renameColumn('stock_quantity', 'stock');
            } elseif (!Schema::hasColumn('products', 'stock') && !Schema::hasColumn('products', 'stock_quantity')) {
                $table->integer('stock')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('slug');
            // stock varsa ve stock_quantity yoksa geri döndürelim
            if (Schema::hasColumn('products', 'stock') && !Schema::hasColumn('products', 'stock_quantity')) {
                $table->renameColumn('stock', 'stock_quantity');
            }
        });
    }
};
