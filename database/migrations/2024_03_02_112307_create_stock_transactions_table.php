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
            $table->date('date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('stock_id');
            $table->unsignedBigInteger('platform_id');
            $table->string('exchange', 12);
            $table->string('quantity', 20);
            $table->string('rate', 20);
            $table->string('price', 20);
            $table->string('transaciton_charge', 20)->nullable();
            $table->boolean('is_buy')->default(true); 
            $table->text('note')->nullable(); 

            $table->softDeletes();
            $table->timestamps();


            $table->index('user_id');
            $table->index('is_buy');
            $table->index('stock_id');
            $table->index('platform_id');
            
        
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
