<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->boolean('track_inventory')
                ->default(true)
                ->after('stock');

            $table->integer('low_stock_alert')
                ->default(5)
                ->after('track_inventory');

            $table->boolean('continue_selling')
                ->default(false)
                ->after('low_stock_alert');

            $table->enum('stock_status', [
                'in_stock',
                'out_of_stock',
                'pre_order'
            ])
            ->default('in_stock')
            ->after('continue_selling');

        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropColumn([
                'track_inventory',
                'low_stock_alert',
                'continue_selling',
                'stock_status'
            ]);

        });
    }
};