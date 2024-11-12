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
        Schema::create('stock_sale_purchase_links', function (Blueprint $table) {

            $table->id();
            $table->foreignId('sale_id')->constrained('stock_transactions');
            $table->foreignId('purchase_id')->constrained('stock_transactions');
            $table->integer('quantity');
            $table->decimal('profit_amount', 10, 2); // profit: total profit on this sale
            $table->timestamps();
            $table->softDeletes();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_sale_purchase_links');
    }
};
