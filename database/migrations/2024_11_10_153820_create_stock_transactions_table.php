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
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('platform_id')->constrained('platforms');
            $table->foreignId('stock_id')->constrained('stocks');
            $table->enum('type', ['buy', 'sell']);
            $table->integer('quantity'); // number of shares
            $table->decimal('price', 10, 2); // price per share
            $table->decimal('total', 10, 2); // total = quantity * price
            $table->timestamps();
            $table->softDeletes();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
