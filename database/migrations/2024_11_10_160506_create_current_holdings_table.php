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
        Schema::create('current_holdings', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('platform_id')->constrained('platforms')->onDelete('cascade'); // Foreign key to stocks table
            $table->foreignId('stock_id')->constrained('stocks')->onDelete('cascade'); // Foreign key to stocks table
            $table->integer('quantity'); // Quantity of stock held
            $table->decimal('average_price', 15, 2); // Average price of stock
            $table->decimal('current_value', 15, 2); // value = quantity * average_price
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_holdings');
    }
};